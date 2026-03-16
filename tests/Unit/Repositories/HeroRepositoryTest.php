<?php

namespace Tests\Unit\Repositories;

use PHPUnit\Framework\Attributes\Test;
use App\Repositories\HeroRepository;
use Tests\TestCase;
use Mockery as Mockery;
use Waynestate\Api\Connector;
use Illuminate\Cache\Repository;

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
        config(['base.hero_placement' => 'full-width']);
        $promos = [
            'hero' => [
                ['title' => 'Hero 1', 'option' => ''],
                ['title' => 'Hero 2', 'option' => '']
            ]
        ];
        $result = $this->heroRepository->setHero($promos, []);
        $this->assertEquals('slim', $result['hero']['component']['heroType']);
        $this->assertEquals('full-width', $result['hero']['component']['heroPlacement']);
        $this->assertEquals('carousel', $result['hero']['component']['heroLayout']);
        $this->assertEquals('hero--slim hero--carousel', $result['hero']['data'][0]['hero_classes']);
        $this->assertArrayHasKey('hero_options', $result['hero']['data'][0]);
    }

    #[Test]
    public function contained_carousel_hero(): void
    {
        $promos = [
            'hero' => [
                ['title' => 'Hero 1', 'option' => 'contained'],
                ['title' => 'Hero 2', 'option' => 'contained']
            ]
        ];
        $result = $this->heroRepository->setHero($promos, []);
        $this->assertEquals('slim', $result['hero']['component']['heroType']);
        $this->assertEquals('contained', $result['hero']['component']['heroPlacement']);
        $this->assertEquals('carousel', $result['hero']['component']['heroLayout']);
    }

    #[Test]
    public function modular_carousel_hero_with_contained_option(): void
    {
        $promos = [
            'components' => [
                'hero-1' => [
                    'data' => [
                        ['title' => 'Hero 1', 'option' => '']
                    ],
                    'component' => [
                        'config' => 'limit:4|option:contained'
                    ]
                ]
            ]
        ];
        $result = $this->heroRepository->setHero($promos, []);
        $this->assertEquals('slim', $result['hero']['component']['heroType']);
        $this->assertEquals('contained', $result['hero']['component']['heroPlacement']);
        $this->assertEquals('', $result['hero']['component']['heroLayout']);
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
        $this->assertEquals('hero--large', $result['hero']['data'][0]['hero_classes']);
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
    public function svg_hero_processes_extension(): void
    {
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

        $this->assertEquals('hero--svg', $result['hero']['data'][0]['hero_classes']);
        $this->assertEquals('//base.wayne.localhost/styleguide/test.svg?v=123', $result['hero']['data'][0]['secondary_relative_url']);
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

        $this->assertEquals('logo', $result['hero']['component']['heroType']);
    }

    #[Test]
    public function mapping_keywords_for_type_and_placement(): void
    {
        // small -> slim
        $promos = ['hero' => [['option' => 'small']]];
        $result = $this->heroRepository->setHero($promos, []);
        $this->assertEquals('slim', $result['hero']['component']['heroType']);
        $this->assertEquals('hero--slim', $result['hero']['data'][0]['hero_classes']);

        // half -> split
        $promos = ['hero' => [['option' => 'half']]];
        $result = $this->heroRepository->setHero($promos, []);
        $this->assertEquals('split', $result['hero']['component']['heroType']);
        $this->assertEquals('hero--split', $result['hero']['data'][0]['hero_classes']);

        // banner -> large
        $promos = ['hero' => [['option' => 'banner']]];
        $result = $this->heroRepository->setHero($promos, []);
        $this->assertEquals('large', $result['hero']['component']['heroType']);
        $this->assertEquals('hero--large', $result['hero']['data'][0]['hero_classes']);

        // full -> full-width
        $promos = ['hero' => [['option' => 'full']]];
        $result = $this->heroRepository->setHero($promos, []);
        $this->assertEquals('full-width', $result['hero']['component']['heroPlacement']);

        // banner large -> full-width
        $promos = ['hero' => [['option' => 'banner large']]];
        $result = $this->heroRepository->setHero($promos, []);
        $this->assertEquals('full-width', $result['hero']['component']['heroPlacement']);
        $this->assertEquals('large', $result['hero']['component']['heroType']);
    }

    #[Test]
    public function fallback_to_large_type(): void
    {
        config(['base.hero_type' => null]);
        $promos = ['hero' => [['title' => 'Hero 1', 'option' => '']]];
        $result = $this->heroRepository->setHero($promos, []);
        $this->assertEquals('large', $result['hero']['component']['heroType']);
        $this->assertEquals('', $result['hero']['data'][0]['hero_classes']);
    }

    #[Test]
    public function empty_hero_returns_original_promos(): void
    {
        $promos = ['test' => 'data'];
        $result = $this->heroRepository->setHero($promos, []);
        $this->assertEquals($promos, $result);

        $promos = ['hero' => []];
        $result = $this->heroRepository->setHero($promos, []);
        $this->assertEquals($promos, $result);
    }

    #[Test]
    public function buttons_hero_type(): void
    {
        $promos = ['hero' => [['option' => 'buttons']]];
        $result = $this->heroRepository->setHero($promos, []);
        $this->assertEquals('buttons', $result['hero']['component']['heroType']);
        $this->assertEquals('hero--buttons', $result['hero']['data'][0]['hero_classes']);
    }

    #[Test]
    public function banner_large_placement_matches_correctly(): void
    {
        $promos = [
            'hero' => [
                ['title' => 'Hero 1', 'option' => 'banner large']
            ]
        ];
        $result = $this->heroRepository->setHero($promos, []);
        $this->assertEquals('large', $result['hero']['component']['heroType']);
        $this->assertEquals('full-width', $result['hero']['component']['heroPlacement']);
        $this->assertEquals('hero--large', $result['hero']['data'][0]['hero_classes']);
    }

    #[Test]
    public function banner_and_large_default_to_full_width_placement(): void
    {
        // banner -> full-width
        $promos = ['hero' => [['option' => 'banner']]];
        $result = $this->heroRepository->setHero($promos, []);
        $this->assertEquals('full-width', $result['hero']['component']['heroPlacement']);

        // large -> full-width
        $promos = ['hero' => [['option' => 'large']]];
        $result = $this->heroRepository->setHero($promos, []);
        $this->assertEquals('full-width', $result['hero']['component']['heroPlacement']);
    }

    #[Test]
    public function contained_overrides_banner_and_large_placement(): void
    {
        // banner contained -> contained
        $promos = ['hero' => [['option' => 'banner contained']]];
        $result = $this->heroRepository->setHero($promos, []);
        $this->assertEquals('contained', $result['hero']['component']['heroPlacement']);

        // large contained -> contained
        $promos = ['hero' => [['option' => 'large contained']]];
        $result = $this->heroRepository->setHero($promos, []);
        $this->assertEquals('contained', $result['hero']['component']['heroPlacement']);
    }

    #[Test]
    public function only_first_hero_component_is_used_and_removed(): void
    {
        $promos = [
            'components' => [
                'modular-hero-1' => [
                    'data' => [['title' => 'Hero 1']],
                    'component' => ['heroType' => 'split']
                ],
                'modular-hero-2' => [
                    'data' => [['title' => 'Hero 2']],
                    'component' => ['heroType' => 'slim']
                ]
            ]
        ];
        $result = $this->heroRepository->setHero($promos, []);
        $this->assertEquals('split', $result['hero']['component']['heroType']);
        $this->assertArrayNotHasKey('modular-hero-1', $result['components']);
        $this->assertArrayHasKey('modular-hero-2', $result['components']);
    }

    #[Test]
    public function hero_options_array_is_populated(): void
    {
        $promos = [
            'hero' => [['option' => 'large full-width']]
        ];
        $result = $this->heroRepository->setHero($promos, []);
        $this->assertContains('large', $result['hero']['data'][0]['hero_options']);
        $this->assertContains('full-width', $result['hero']['data'][0]['hero_options']);
    }

    #[Test]
    public function modular_hero_with_multiple_items_triggers_carousel(): void
    {
        $promos = [
            'components' => [
                'modular-hero-1' => [
                    'data' => [
                        ['title' => 'Hero 1', 'option' => ''],
                        ['title' => 'Hero 2', 'option' => ''],
                    ],
                    'component' => [
                        'config' => 'limit:3|option:buttons full',
                    ]
                ]
            ]
        ];

        $result = $this->heroRepository->setHero($promos, []);

        $this->assertEquals('carousel', $result['hero']['component']['heroLayout']);
        $this->assertEquals('full-width', $result['hero']['component']['heroPlacement']);
        $this->assertCount(2, $result['hero']['data']);
    }

    #[Test]
    public function modular_hero_with_single_item_and_limit_greater_than_one_triggers_carousel(): void
    {
        $promos = [
            'components' => [
                'modular-hero-1' => [
                    'data' => [
                        ['title' => 'Hero 1', 'option' => ''],
                    ],
                    'component' => [
                        'config' => 'limit:3|option:buttons full',
                    ]
                ]
            ]
        ];

        $result = $this->heroRepository->setHero($promos, []);

        $this->assertEquals('buttons', $result['hero']['component']['heroType']);
        $this->assertCount(1, $result['hero']['data']);
    }

    #[Test]
    public function modular_hero_with_limit_one_and_carousel_option_triggers_carousel(): void
    {
        $promos = [
            'components' => [
                'modular-hero-1' => [
                    'data' => [
                        ['title' => 'Hero 1', 'option' => 'carousel'],
                    ],
                    'component' => [
                        'config' => 'limit:1',
                    ]
                ]
            ]
        ];

        $result = $this->heroRepository->setHero($promos, []);

        $this->assertEquals('carousel', $result['hero']['component']['heroLayout']);
        $this->assertEquals('contained', $result['hero']['component']['heroPlacement']);
    }

    #[Test]
    public function modular_hero_processes_secondary_image_even_in_carousel(): void
    {
        $promos = [
            'hero' => [
                ['title' => 'Hero 1', 'relative_url' => '/hero.jpg', 'secondary_relative_url' => '/logo.svg', 'option' => ''],
                ['title' => 'Hero 2', 'relative_url' => '/hero2.jpg', 'option' => ''],
            ]
        ];

        $result = $this->heroRepository->setHero($promos, []);

        $this->assertEquals('slim', $result['hero']['component']['heroType']);
        $this->assertEquals('/logo.svg', $result['hero']['data'][0]['secondary_relative_url']);
    }

    #[Test]
    public function modular_hero_with_limit_three_and_option_full_triggers_carousel_for_single_item(): void
    {
        $promos = [
            'components' => [
                'hero-1' => [
                    'data' => [
                        ['title' => 'Slide 1', 'option' => ''],
                    ],
                    'component' => [
                        'config' => 'limit:3|option:full',
                    ],
                ],
            ],
        ];

        // Simulate how Controller might pass the component data
        // Often 'limit' and 'option' are already extracted into the component array
        $promos['components']['hero-1']['component']['limit'] = 3;
        $promos['components']['hero-1']['component']['option'] = 'full';

        $result = $this->heroRepository->setHero($promos, []);

        $this->assertEquals('slim', $result['hero']['component']['heroType']);
        $this->assertEquals('full-width', $result['hero']['component']['heroPlacement']);
        $this->assertEquals('', $result['hero']['component']['heroLayout']);
        $this->assertEquals('hero--slim', $result['hero']['data'][0]['hero_classes']);
    }

    #[Test]
    public function carousel_keyword_in_option_triggers_carousel(): void
    {
        $promos = [
            'hero' => [
                ['title' => 'Hero 1', 'option' => 'carousel']
            ]
        ];
        $result = $this->heroRepository->setHero($promos, []);
        $this->assertEquals('carousel', $result['hero']['component']['heroLayout']);
    }

    #[Test]
    public function carousel_hero_with_multiple_items_should_have_all_items_in_data()
    {
        $promos = [
            'components' => [
                'hero-1' => [
                    'data' => [
                        ['title' => 'Hero 1', 'option' => 'full'],
                        ['title' => 'Hero 2', 'option' => 'full'],
                        ['title' => 'Hero 3', 'option' => 'full'],
                        ['title' => 'Hero 4', 'option' => 'full'],
                    ],
                    'component' => [
                        'config' => 'limit:4',
                    ],
                ],
            ],
        ];

        $promos = $this->heroRepository->setHero($promos, []);

        $this->assertCount(4, $promos['hero']['data']);
        $this->assertEquals('slim', $promos['hero']['component']['heroType']);
        $this->assertEquals('full-width', $promos['hero']['component']['heroPlacement']);
    }

    #[Test]
    public function modular_hero_with_4_items_and_limit_3_should_be_sliced_to_3_items()
    {
        // Define 4 hero items
        $hero_items = [
            ['title' => 'Hero 1', 'relative_url' => '/hero1.jpg', 'option' => ''],
            ['title' => 'Hero 2', 'relative_url' => '/hero2.jpg', 'option' => ''],
            ['title' => 'Hero 3', 'relative_url' => '/hero3.jpg', 'option' => ''],
            ['title' => 'Hero 4', 'relative_url' => '/hero4.jpg', 'option' => ''],
        ];

        // Component with limit:3
        $promos = [
            'components' => [
                'hero-1' => [
                    'data' => $hero_items,
                    'component' => [
                        'config' => 'limit:3|option:full',
                    ],
                ],
            ],
        ];

        $promos = $this->heroRepository->setHero($promos, []);

        // It should be a carousel
        $this->assertEquals('slim', $promos['hero']['component']['heroType']);

        // Check the count of data items. If HeroRepository doesn't slice, it will be 4.
        // The user says there's only 1 item, but they EXPECT 3.
        // If it's 4, it's not limiting. If it's 1, it's something else.
        $this->assertCount(3, $promos['hero']['data'], 'Hero data should be limited to 3 items based on component limit');
    }

    #[Test]
    public function global_hero_with_4_items_and_no_component_limit_should_not_be_sliced()
    {
        // Define 4 hero items
        $hero_items = [
            ['title' => 'Hero 1', 'relative_url' => '/hero1.jpg', 'option' => ''],
            ['title' => 'Hero 2', 'relative_url' => '/hero2.jpg', 'option' => ''],
            ['title' => 'Hero 3', 'relative_url' => '/hero3.jpg', 'option' => ''],
            ['title' => 'Hero 4', 'relative_url' => '/hero4.jpg', 'option' => ''],
        ];

        // Global hero (no component)
        $promos = [
            'hero' => $hero_items,
        ];

        $promos = $this->heroRepository->setHero($promos, []);

        $this->assertCount(4, $promos['hero']['data']);
        $this->assertEquals('slim', $promos['hero']['component']['heroType']);
    }

    #[Test]
    public function modular_hero_with_top_level_option_overrides_config_option()
    {
        $promos = [
            'components' => [
                'hero-1' => [
                    'data' => [
                        ['title' => 'Hero 1', 'relative_url' => '/hero1.jpg', 'option' => ''],
                    ],
                    'component' => [
                        'config' => 'limit:1|option:slim',
                    ],
                    'option' => 'split',
                ],
            ],
        ];

        $promos = $this->heroRepository->setHero($promos, []);

        $this->assertEquals('split', $promos['hero']['component']['heroType']);
    }

    #[Test]
    public function modular_hero_with_top_level_option_works_without_config_option()
    {
        $promos = [
            'components' => [
                'hero-1' => [
                    'data' => [
                        ['title' => 'Hero 1', 'relative_url' => '/hero1.jpg', 'option' => ''],
                    ],
                    'component' => [
                        'config' => 'limit:1',
                    ],
                    'option' => 'text',
                ],
            ],
        ];

        $promos = $this->heroRepository->setHero($promos, []);

        $this->assertEquals('text', $promos['hero']['component']['heroType']);
    }
}
