<?php

namespace Tests\Unit\Repositories;

use PHPUnit\Framework\Attributes\Test;
use App\Repositories\HeroRepository;
use Tests\TestCase;
use Mockery as Mockery;
use Waynestate\Api\Connector;
use Illuminate\Cache\Repository;
use Illuminate\Support\Facades\Storage;

final class HeroRepositoryTest extends TestCase
{
    private HeroRepository $heroRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $wsuApi = Mockery::mock(Connector::class);
        $cache = Mockery::mock(Repository::class);

        $this->heroRepository = new HeroRepository($wsuApi, $cache);
    }

    #[Test]
    public function carousel_hero_with_multiple_promos(): void
    {
        $promos = [
            'hero' => [
                ['title' => 'Hero 1', 'option' => ''],
                ['title' => 'Hero 2', 'option' => '']
            ]
        ];
        $result = $this->heroRepository->setHero($promos, []);
        $this->assertEquals('carousel', $result['hero']['component']['heroType']);
        $this->assertEquals('full-width', $result['hero']['component']['heroPlacement']);
        $this->assertEquals('hero--large', $result['hero']['data'][0]['hero_classes']);
    }

    #[Test]
    public function contained_slim_hero_default(): void
    {
        config(['base.hero_type' => 'slim']);
        config(['base.hero_placement' => 'contained']);
        $promos = [
            'hero' => [
                ['title' => 'Hero 1', 'option' => '']
            ]
        ];
        $result = $this->heroRepository->setHero($promos, []);
        $this->assertEquals('slim', $result['hero']['component']['heroType']);
        $this->assertEquals('contained', $result['hero']['component']['heroPlacement']);
    }

    #[Test]
    public function full_width_large_hero(): void
    {
        $promos = [
            'hero' => [
                ['title' => 'Hero 1', 'option' => 'large full-width']
            ]
        ];
        $result = $this->heroRepository->setHero($promos, []);
        $this->assertEquals('large', $result['hero']['component']['heroType']);
        $this->assertEquals('full-width', $result['hero']['component']['heroPlacement']);
    }

    #[Test]
    public function split_hero(): void
    {
        $promos = [
            'hero' => [
                ['title' => 'Hero 1', 'option' => 'split']
            ]
        ];
        $result = $this->heroRepository->setHero($promos, []);
        $this->assertEquals('split', $result['hero']['component']['heroType']);
        $this->assertEquals('hero--split', $result['hero']['data'][0]['hero_classes']);
    }

    #[Test]
    public function text_only_hero(): void
    {
        $promos = [
            'hero' => [
                ['title' => 'Hero 1', 'option' => 'text']
            ]
        ];
        $result = $this->heroRepository->setHero($promos, []);
        $this->assertEquals('text', $result['hero']['component']['heroType']);
        $this->assertEquals('hero--text', $result['hero']['data'][0]['hero_classes']);
    }

    #[Test]
    public function svg_or_logo_hero(): void
    {
        $promos = [
            'hero' => [
                ['title' => 'Hero 1', 'option' => 'svg']
            ]
        ];
        $result = $this->heroRepository->setHero($promos, []);
        $this->assertEquals('svg', $result['hero']['component']['heroType']);
        $this->assertEquals('hero--svg', $result['hero']['data'][0]['hero_classes']);

        $promos = [
            'hero' => [
                ['title' => 'Hero 1', 'option' => 'logo']
            ]
        ];
        $result = $this->heroRepository->setHero($promos, []);
        $this->assertEquals('logo', $result['hero']['component']['heroType']);
    }

    #[Test]
    public function custom_component_override(): void
    {
        $promos = [
            'components' => [
                'modular-hero-1' => [
                    'data' => [
                        ['title' => 'Component Hero']
                    ],
                    'component' => [
                        'heroType' => 'split',
                        'heroPlacement' => 'full-width'
                    ]
                ]
            ]
        ];
        $result = $this->heroRepository->setHero($promos, []);
        $this->assertEquals('split', $result['hero']['component']['heroType']);
        $this->assertEquals('full-width', $result['hero']['component']['heroPlacement']);
        // The component should be removed from components array
        $this->assertArrayNotHasKey('modular-hero-1', $result['components']);
    }

    #[Test]
    public function set_hero_handles_hero_buttons_component(): void
    {
        $promos = [
            'components' => [
                'hero-buttons-1' => [
                    'data' => [
                        ['title' => 'Button 1']
                    ]
                ]
            ]
        ];
        $result = $this->heroRepository->setHero($promos, []);
        $this->assertArrayHasKey('hero_buttons', $result);
        $this->assertEquals('Button 1', $result['hero_buttons']['data'][0]['title']);
        $this->assertArrayNotHasKey('hero-buttons-1', $result['components']);
    }

    #[Test]
    public function modular_hero_with_option_in_component_config(): void
    {
        $promos = [
            'components' => [
                'modular-hero-1' => [
                    'data' => [
                        ['title' => 'Hero 1', 'option' => '']
                    ],
                    'component' => [
                        'option' => 'text full-width',
                    ]
                ]
            ]
        ];

        $result = $this->heroRepository->setHero($promos, []);

        $this->assertEquals('text', $result['hero']['component']['heroType']);
        $this->assertEquals('full-width', $result['hero']['component']['heroPlacement']);
    }

    #[Test]
    public function modular_hero_option_overrides_explicit_config(): void
    {
        $promos = [
            'components' => [
                'modular-hero-1' => [
                    'data' => [
                        ['title' => 'Hero 1', 'option' => '']
                    ],
                    'component' => [
                        'heroType' => 'slim',
                        'heroPlacement' => 'contained',
                        'option' => 'text full-width',
                    ]
                ]
            ]
        ];

        $result = $this->heroRepository->setHero($promos, []);

        $this->assertEquals('text', $result['hero']['component']['heroType']);
        $this->assertEquals('full-width', $result['hero']['component']['heroPlacement']);
    }

    #[Test]
    public function modular_hero_with_option_in_config_string(): void
    {
        $promos = [
            'components' => [
                'modular-hero-1' => [
                    'data' => [
                        ['title' => 'Hero 1', 'option' => '']
                    ],
                    'component' => [
                        'config' => 'limit:1|option:large full-width|youtube',
                    ]
                ]
            ]
        ];

        $result = $this->heroRepository->setHero($promos, []);

        $this->assertEquals('large', $result['hero']['component']['heroType']);
        $this->assertEquals('full-width', $result['hero']['component']['heroPlacement']);
    }

    #[Test]
    public function modular_hero_option_overrides_promo_option(): void
    {
        $promos = [
            'components' => [
                'modular-hero-1' => [
                    'data' => [
                        ['title' => 'Hero 1', 'option' => 'banner small']
                    ],
                    'component' => [
                        'config' => 'option:large full-width',
                    ]
                ]
            ]
        ];

        $result = $this->heroRepository->setHero($promos, []);

        // Even though promo has 'small', component has 'large'
        $this->assertEquals('large', $result['hero']['component']['heroType']);
        $this->assertEquals('full-width', $result['hero']['component']['heroPlacement']);
    }
    #[Test]
    public function svg_hero_processes_extension_and_base64(): void
    {
        Storage::fake('public');
        Storage::fake('base');

        Storage::disk('public')->put('styleguide/test.svg', '<svg></svg>');

        $promos = [
            'hero' => [
                [
                    'title' => 'Hero 1',
                    'option' => 'svg',
                    'secondary_relative_url' => '//base.wayne.localhost/styleguide/test.svg?v=123'
                ]
            ]
        ];
        $result = $this->heroRepository->setHero($promos, []);

        $this->assertEquals('svg', $result['hero']['data'][0]['secondary_extension']);
        $this->assertStringContainsString('data:image/svg+xml;base64,', $result['hero']['data'][0]['secondary_relative_url']);
        $this->assertEquals('data:image/svg+xml;base64,'.base64_encode('<svg></svg>'), $result['hero']['data'][0]['secondary_relative_url']);

        // Test with base disk fallback
        Storage::disk('base')->put('styleguide/test_base.svg', '<svg>base</svg>');

        $promosBase = [
            'hero' => [
                [
                    'title' => 'Hero 1',
                    'option' => 'svg',
                    'secondary_relative_url' => '/styleguide/test_base.svg'
                ]
            ]
        ];
        $resultBase = $this->heroRepository->setHero($promosBase, []);
        $this->assertEquals('data:image/svg+xml;base64,'.base64_encode('<svg>base</svg>'), $resultBase['hero']['data'][0]['secondary_relative_url']);

        // Test with base disk public/ fallback
        Storage::disk('base')->put('public/styleguide/test_base_public.svg', '<svg>base public</svg>');

        $promosBasePublic = [
            'hero' => [
                [
                    'title' => 'Hero 1',
                    'option' => 'svg',
                    'secondary_relative_url' => '/styleguide/test_base_public.svg'
                ]
            ]
        ];
        $resultBasePublic = $this->heroRepository->setHero($promosBasePublic, []);
        $this->assertEquals('data:image/svg+xml;base64,'.base64_encode('<svg>base public</svg>'), $resultBasePublic['hero']['data'][0]['secondary_relative_url']);

        // Test that it handles missing files gracefully
        $promosMissing = [
            'hero' => [
                [
                    'title' => 'Hero 1',
                    'option' => 'svg',
                    'secondary_relative_url' => 'styleguide/missing.svg'
                ]
            ]
        ];
        $resultMissing = $this->heroRepository->setHero($promosMissing, []);
        $this->assertEquals('svg', $resultMissing['hero']['data'][0]['secondary_extension']);
        $this->assertEquals('styleguide/missing.svg', $resultMissing['hero']['data'][0]['secondary_relative_url']);
    }

    #[Test]
    public function logo_hero_processes_extension(): void
    {
        $promos = [
            'hero' => [
                [
                    'title' => 'Hero 1',
                    'option' => 'logo',
                    'secondary_relative_url' => '/styleguide/image.png'
                ]
            ]
        ];
        $result = $this->heroRepository->setHero($promos, []);

        $this->assertEquals('png', $result['hero']['data'][0]['secondary_extension']);
    }
}
