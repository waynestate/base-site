<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use Mockery as Mockery;

class PromoRepositoryTest extends TestCase
{
    /**
     * @covers App\Repositories\PromoRepository::__construct
     * @covers App\Repositories\PromoRepository::getRequestData
     * @test
     */
    public function getting_promos_with_custom_page_accordion_should_return_accordion_page()
    {
        // Fake return
        $return = [
            'promotions' => [],
        ];

        // Always force homepage
        config(['base.hero_rotating_controllers' => ['HomepageController']]);

        // Create a fake data request
        $data = app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'HomepageController',
            ],
            'data' => [
                'accordion_promo_group_id' => $this->faker->numberbetween(1, 3),
            ],
        ]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock('Waynestate\Api\Connector');
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);

        // Get the promos
        $promos = app('App\Repositories\PromoRepository', ['wsuApi' => $wsuApi])->getRequestData($data);

        $this->assertArrayHasKey('accordion_page', $promos);
    }

    /**
     * @covers App\Repositories\PromoRepository::__construct
     * @covers App\Repositories\PromoRepository::getRequestData
     * @test
     */
    public function subsite_overriding_main_contact_social_and_under_menu()
    {
        // Fake return
        $return = [
            'promotions' => [
                [
                    'promo_item_id' => 1,
                    'promo_group_id' => 1,
                ],
                [
                    'promo_item_id' => 2,
                    'promo_group_id' => 2,
                ],
                [
                    'promo_item_id' => 3,
                    'promo_group_id' => 3,
                ],
                [
                    'promo_item_id' => 4,
                    'promo_group_id' => 4,
                ],
                [
                    'promo_item_id' => 5,
                    'promo_group_id' => 5,
                ],
                [
                    'promo_item_id' => 6,
                    'promo_group_id' => 6,
                ],
            ],
        ];

        // Create a fake data request
        $data = app('Factories\Page')->create(1, true, [
            'site' => [
                'id' => 2,
                'parent' => [
                    'id' => 1,
                ],
            ],
        ]);

        // Build the config
        config(['base.global' => [
            'all' => [
                'promos' => [
                    'main_contact' => [
                        'id' => 1,
                        'config' => 'limit:1',
                    ],
                    'main_social' => [
                        'id' => 2,
                        'config' => 'limit:1',
                    ],
                    'main_under_menu' => [
                        'id' => 5,
                        'config' => 'limit:1',
                    ],
                ],
            ],
            'sites' => [
                $data['site']['id'] => [
                    'promos' => [
                        'contact' => [
                            'id' => 3,
                            'merge_with_main_contact' => false,
                        ],
                        'social' => [
                            'id' => 4,
                        ],
                        'under_menu' => [
                            'id' => 6,
                            'merge_with_main_under_menu' => false,
                        ],
                    ],
                ],
            ],
        ]]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock('Waynestate\Api\Connector');
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);

        // Get the promos
        $promos = app('App\Repositories\PromoRepository', ['wsuApi' => $wsuApi])->getRequestData($data);

        // Make sure that the count is equal to the main config limit
        $this->assertCount(1, $promos['contact']);
        $this->assertEquals(3, $promos['contact'][3]['promo_group_id']);
        $this->assertCount(1, $promos['social']);
        $this->assertEquals(4, $promos['social'][4]['promo_group_id']);
        $this->assertCount(1, $promos['under_menu']);
        $this->assertEquals(6, $promos['under_menu'][6]['promo_group_id']);
    }

    /**
     * @covers App\Repositories\PromoRepository::__construct
     * @covers App\Repositories\PromoRepository::getRequestData
     * @test
     */
    public function subsite_using_main_contact_social_and_under_menu()
    {
        // Fake return
        $return = [
            'promotions' => [
                [
                    'promo_item_id' => 1,
                    'promo_group_id' => 1,
                ],
                [
                    'promo_item_id' => 2,
                    'promo_group_id' => 2,
                ],
                [
                    'promo_item_id' => 3,
                    'promo_group_id' => 3,
                ],
            ],
        ];

        // Create a fake data request
        $data = app('Factories\Page')->create(1, true, [
            'site' => [
                'id' => 2,
                'parent' => [
                    'id' => 1,
                ],
            ],
        ]);

        // Build the config
        config(['base.global' => [
            'all' => [
                'promos' => [
                    'main_contact' => [
                        'id' => 1,
                        'config' => 'limit:1',
                    ],
                    'main_social' => [
                        'id' => 2,
                        'config' => 'limit:1',
                    ],
                    'main_under_menu' => [
                        'id' => 3,
                        'config' => 'limit:1',
                    ],
                ],
            ],
        ]]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock('Waynestate\Api\Connector');
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);

        // Get the promos
        $promos = app('App\Repositories\PromoRepository', ['wsuApi' => $wsuApi])->getRequestData($data);

        // Make sure that the count is equal to the main config limit
        $this->assertCount(1, $promos['contact']);
        $this->assertEquals(1, $promos['contact'][1]['promo_group_id']);
        $this->assertCount(1, $promos['social']);
        $this->assertEquals(2, $promos['social'][2]['promo_group_id']);
        $this->assertCount(1, $promos['under_menu']);
        $this->assertEquals(3, $promos['under_menu'][3]['promo_group_id']);
    }

    /**
     * @covers App\Repositories\PromoRepository::__construct
     * @covers App\Repositories\PromoRepository::getRequestData
     * @test
     */
    public function subsite_contact_merging_with_main_contact_and_under_menu()
    {
        // Fake return
        $return = [
            'promotions' => [
                [
                    'promo_item_id' => 1,
                    'promo_group_id' => 1,
                ],
                [
                    'promo_item_id' => 2,
                    'promo_group_id' => 2,
                ],
                [
                    'promo_item_id' => 3,
                    'promo_group_id' => 3,
                ],
                [
                    'promo_item_id' => 4,
                    'promo_group_id' => 4,
                ],
            ],
        ];

        // Create a fake data request
        $data = app('Factories\Page')->create(1, true, [
            'site' => [
                'id' => 2,
                'parent' => [
                    'id' => 1,
                ],
            ],
        ]);

        // Build the config
        config(['base.global' => [
            'all' => [
                'promos' => [
                    'main_contact' => [
                        'id' => 1,
                        'config' => 'limit:1',
                    ],
                    'main_under_menu' => [
                        'id' => 3,
                        'config' => 'limit:1',
                    ],
                ],
            ],
            'sites' => [
                $data['site']['id'] => [
                    'promos' => [
                        'contact' => [
                            'id' => 2,
                            'merge_with_main_contact' => true,
                        ],
                        'under_menu' => [
                            'id' => 4,
                            'merge_with_main_under_menu' => true,
                        ],
                    ],
                ],
            ],
        ]]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock('Waynestate\Api\Connector');
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);

        // Get the promos
        $promos = app('App\Repositories\PromoRepository', ['wsuApi' => $wsuApi])->getRequestData($data);

        $this->assertCount(2, $promos['contact']);
        $this->assertCount(2, $promos['under_menu']);
    }

    /**
     * @covers App\Repositories\PromoRepository::__construct
     * @covers App\Repositories\PromoRepository::getRequestData
     * @test
     */
    public function subsite_contact_merging_with_no_main_contact()
    {
        // Fake return
        $return = [
            'promotions' => [
                [
                    'promo_item_id' => 2,
                    'promo_group_id' => 2,
                ],
            ],
        ];

        // Create a fake data request
        $data = app('Factories\Page')->create(1, true, [
            'site' => [
                'id' => 2,
                'parent' => [
                    'id' => 1,
                ],
            ],
        ]);

        // Build the config
        config(['base.global' => [
            'all' => [
                'promos' => [
                    'main_contact' => [
                        'id' => null,
                        'config' => 'limit:1',
                    ],
                ],
            ],
            'sites' => [
                $data['site']['id'] => [
                    'promos' => [
                        'contact' => [
                            'id' => 2,
                            'merge_with_main_contact' => true,
                        ],
                    ],
                ],
            ],
        ]]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock('Waynestate\Api\Connector');
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);

        // Get the promos
        $promos = app('App\Repositories\PromoRepository', ['wsuApi' => $wsuApi])->getRequestData($data);

        $this->assertCount(1, $promos['contact']);
    }

    /**
     * @covers App\Repositories\PromoRepository::__construct
     * @covers App\Repositories\PromoRepository::getRequestData
     * @test
     */
    public function subsite_under_menu_merging_with_no_main_under_menu()
    {
        // Fake return
        $return = [
            'promotions' => [
                [
                    'promo_item_id' => 2,
                    'promo_group_id' => 2,
                ],
            ],
        ];

        // Create a fake data request
        $data = app('Factories\Page')->create(1, true, [
            'site' => [
                'id' => 2,
                'parent' => [
                    'id' => 1,
                ],
            ],
        ]);

        // Build the config
        config(['base.global' => [
            'all' => [
                'promos' => [
                    'main_under_menu' => [
                        'id' => null,
                        'config' => 'limit:1',
                    ],
                ],
            ],
            'sites' => [
                $data['site']['id'] => [
                    'promos' => [
                        'under_menu' => [
                            'id' => 2,
                            'merge_with_main_under_menu' => true,
                        ],
                    ],
                ],
            ],
        ]]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock('Waynestate\Api\Connector');
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);

        // Get the promos
        $promos = app('App\Repositories\PromoRepository', ['wsuApi' => $wsuApi])->getRequestData($data);

        $this->assertCount(1, $promos['under_menu']);
    }

    /**
     * @covers App\Repositories\PromoRepository::getHomepagePromos
     * @test
     */
    public function getting_homepage_promos_should_return_array()
    {
        // Fake return
        $return = [
            'promotions' => [],
        ];

        // Mock the connector and set the return
        $wsuApi = Mockery::mock('Waynestate\Api\Connector');
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);

        // Get the promos
        $promos = app('App\Repositories\PromoRepository', ['wsuApi' => $wsuApi])->getHomepagePromos($this->faker->randomDigit);

        $this->assertTrue(is_array($promos));
    }
}
