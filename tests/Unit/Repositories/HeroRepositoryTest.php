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
    public function set_hero_with_banner_contained_option(): void
    {
        // Test Banner contained option is set
        $promos = [
            'hero' => [
                [
                    'option' => 'Banner contained',
                    'title' => 'Test Hero'
                ]
            ],
            'components' => []
        ];

        $data = [
            'page' => [
                'controller' => 'TestController'
            ]
        ];

        $result = $this->heroRepository->setHero($promos, $data);

        $this->assertEquals('Banner contained', $result['hero']['component']['option']);
    }

    #[Test]
    public function set_hero_with_contained_hero_layout_and_no_option(): void
    {
        // Test Layout is 'contained-hero' and no option is set
        config(['base.layout' => 'contained-hero']);

        $promos = [
            'hero' => [
                [
                    'title' => 'Test Hero'
                    // No 'option' key set
                ]
            ],
            'components' => []
        ];

        $data = [
            'page' => [
                'controller' => 'TestController'
            ]
        ];

        $result = $this->heroRepository->setHero($promos, $data);

        $this->assertEquals('Banner contained', $result['hero']['component']['option']);
    }

    #[Test]
    public function set_hero_overrides_from_components(): void
    {
        // Test Hero component override functionality
        $promos = [
            'components' => [
                'modular-hero-1' => [
                    'data' => [
                        [
                            'title' => 'Component Hero',
                            'description' => 'This is from a component'
                        ]
                    ]
                ]
            ]
        ];

        $data = [
            'page' => [
                'controller' => 'TestController'
            ]
        ];

        $result = $this->heroRepository->setHero($promos, $data);

        // The hero should be set from the component
        $this->assertArrayHasKey('hero', $result);
        $this->assertEquals('Component Hero', $result['hero']['data'][0]['title']);

        // The component should be removed from components array
        $this->assertArrayNotHasKey('modular-hero-1', $result['components']);

        // Config should be set for hero_full_controllers
        $this->assertContains('TestController', config('base.hero_full_controllers'));
    }

    #[Test]
    public function set_hero_replaces_buttons_option_with_text_overlay(): void
    {
        // Test Buttons option is replaced with Text Overlay
        $promos = [
            'hero' => [
                [
                    'option' => 'Buttons',
                    'title' => 'Test Hero with Buttons'
                ]
            ],
            'components' => []
        ];

        $data = [
            'page' => [
                'controller' => 'TestController'
            ]
        ];

        $result = $this->heroRepository->setHero($promos, $data);

        $this->assertArrayHasKey('hero', $result);
        $this->assertArrayHasKey('data', $result['hero']);
        $this->assertArrayHasKey(0, $result['hero']['data']);
        $this->assertEquals('Text Overlay', $result['hero']['data'][0]['option']);
    }

    #[Test]
    public function set_hero_handles_hero_buttons_component(): void
    {
        // Test hero buttons functionality
        $promos = [
            'components' => [
                'hero-buttons-1' => [
                    'data' => [
                        [
                            'title' => 'Button 1',
                            'url' => 'http://example.com'
                        ]
                    ]
                ]
            ]
        ];

        $data = [
            'page' => [
                'controller' => 'TestController'
            ]
        ];

        $result = $this->heroRepository->setHero($promos, $data);

        // Hero buttons should be moved to hero_buttons key
        $this->assertArrayHasKey('hero_buttons', $result);
        $this->assertEquals('Button 1', $result['hero_buttons']['data'][0]['title']);

        // Component should be removed
        $this->assertArrayNotHasKey('hero-buttons-1', $result['components']);
    }

    #[Test]
    public function set_hero_with_multiple_hero_data_items_does_not_set_component_option(): void
    {
        // When there are multiple hero items, component option should not be set
        $promos = [
            'hero' => [
                [
                    'option' => 'Banner contained',
                    'title' => 'Hero 1'
                ],
                [
                    'option' => 'Banner small',
                    'title' => 'Hero 2'
                ]
            ],
            'components' => []
        ];

        $data = [
            'page' => [
                'controller' => 'TestController'
            ]
        ];

        $result = $this->heroRepository->setHero($promos, $data);

        // Component option should not be set when there are multiple hero items
        // but the component key should still exist as an empty array
        $this->assertArrayHasKey('component', $result['hero']);
        $this->assertEmpty($result['hero']['component']);
    }

    #[Test]
    public function set_hero_preserves_existing_hero_data_structure(): void
    {
        // Test that hero data is preserved when forcing into component structure
        $promos = [
            'hero' => [
                [
                    'title' => 'Test Hero',
                    'description' => 'Test Description'
                ]
            ],
            'components' => []
        ];

        $data = [
            'page' => [
                'controller' => 'TestController'
            ]
        ];

        $result = $this->heroRepository->setHero($promos, $data);

        // Hero data should be moved to data key
        $this->assertArrayHasKey('data', $result['hero']);
        $this->assertEquals('Test Hero', $result['hero']['data'][0]['title']);
        $this->assertEquals('Test Description', $result['hero']['data'][0]['description']);
    }

    #[Test]
    public function set_hero_with_empty_promos_returns_unchanged(): void
    {
        // Test that empty promos are returned unchanged
        $promos = [
            'components' => []
        ];
        $data = [
            'page' => [
                'controller' => 'TestController'
            ]
        ];

        $result = $this->heroRepository->setHero($promos, $data);

        $this->assertEquals($promos, $result);
    }

    #[Test]
    public function set_hero_with_no_option_and_different_layout_sets_banner_small(): void
    {
        // Test the final elseif condition for Banner small
        config(['base.layout' => 'full-width']); // Not 'contained-hero'

        $promos = [
            'hero' => [
                [
                    'title' => 'Test Hero'
                    // No 'option' key set
                ]
            ],
            'components' => []
        ];

        $data = [
            'page' => [
                'controller' => 'TestController'
            ]
        ];

        $result = $this->heroRepository->setHero($promos, $data);

        $this->assertEquals('Banner small', $result['hero']['component']['option']);
    }
}
