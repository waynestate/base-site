<?php

namespace Tests\Unit\Repositories;

use App\Repositories\PromoRepository;
use Factories\Page;
use Factories\PromoListing;
use Illuminate\Support\Str;
use Tests\TestCase;
use Mockery as Mockery;
use Waynestate\Api\Connector;

class PromoRepositoryTest extends TestCase
{
    /**
     * @covers \App\Repositories\PromoRepository::__construct
     * @covers \App\Repositories\PromoRepository::getRequestData
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
        $data = app(Page::class)->create(1, true, [
            'page' => [
                'controller' => 'HomepageController',
            ],
            'data' => [
                'accordion_promo_group_id' => $this->faker->numberbetween(1, 3),
            ],
        ]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);

        // Get the promos
        $promos = app(PromoRepository::class, ['wsuApi' => $wsuApi])->getRequestData($data);

        $this->assertArrayHasKey('accordion_page', $promos);
    }

    /**
     * @covers \App\Repositories\PromoRepository::__construct
     * @covers \App\Repositories\PromoRepository::getRequestData
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
        $data = app(Page::class)->create(1, true, [
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
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);

        // Get the promos
        $promos = app(PromoRepository::class, ['wsuApi' => $wsuApi])->getRequestData($data);

        // Make sure that the count is equal to the main config limit
        $this->assertCount(1, $promos['contact']);
        $this->assertEquals(3, $promos['contact'][3]['promo_group_id']);
        $this->assertCount(1, $promos['social']);
        $this->assertEquals(4, $promos['social'][4]['promo_group_id']);
        $this->assertCount(1, $promos['under_menu']);
        $this->assertEquals(6, $promos['under_menu'][6]['promo_group_id']);
    }

    /**
     * @covers \App\Repositories\PromoRepository::__construct
     * @covers \App\Repositories\PromoRepository::getRequestData
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
        $data = app(Page::class)->create(1, true, [
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
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);

        // Get the promos
        $promos = app(PromoRepository::class, ['wsuApi' => $wsuApi])->getRequestData($data);

        // Make sure that the count is equal to the main config limit
        $this->assertCount(1, $promos['contact']);
        $this->assertEquals(1, $promos['contact'][1]['promo_group_id']);
        $this->assertCount(1, $promos['social']);
        $this->assertEquals(2, $promos['social'][2]['promo_group_id']);
        $this->assertCount(1, $promos['under_menu']);
        $this->assertEquals(3, $promos['under_menu'][3]['promo_group_id']);
    }

    /**
     * @covers \App\Repositories\PromoRepository::__construct
     * @covers \App\Repositories\PromoRepository::getRequestData
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
        $data = app(Page::class)->create(1, true, [
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
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);

        // Get the promos
        $promos = app(PromoRepository::class, ['wsuApi' => $wsuApi])->getRequestData($data);

        $this->assertCount(2, $promos['contact']);
        $this->assertCount(2, $promos['under_menu']);
    }

    /**
     * @covers \App\Repositories\PromoRepository::__construct
     * @covers \App\Repositories\PromoRepository::getRequestData
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
        $data = app(Page::class)->create(1, true, [
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
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);

        // Get the promos
        $promos = app(PromoRepository::class, ['wsuApi' => $wsuApi])->getRequestData($data);

        $this->assertCount(1, $promos['contact']);
    }

    /**
     * @covers \App\Repositories\PromoRepository::__construct
     * @covers \App\Repositories\PromoRepository::getRequestData
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
        $data = app(Page::class)->create(1, true, [
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
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);

        // Get the promos
        $promos = app(PromoRepository::class, ['wsuApi' => $wsuApi])->getRequestData($data);

        $this->assertCount(1, $promos['under_menu']);
    }

    /**
     * @covers \App\Repositories\PromoRepository::getHomepagePromos
     * @test
     */
    public function getting_homepage_promos_should_return_array()
    {
        // Fake return
        $return = [
            'promotions' => [],
        ];

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);

        // Get the promos
        $promos = app(PromoRepository::class, ['wsuApi' => $wsuApi])->getHomepagePromos($this->faker->randomDigit);

        $this->assertTrue(is_array($promos));
    }

    /**
     * @covers \App\Repositories\PromoRepository::getPromoListingPromos
     * @test
     */
    public function getting_promos_listing_as_listing_should_return_listing_array()
    {
        $promo_group_id = $this->faker->numberbetween(1, 3);

        // Fake return
        $return['promotions'] = app(PromoListing::class)->create(5, false, [
            'promo_group_id' => $promo_group_id,
        ]);

        // Create a fake data request
        $data = app(Page::class)->create(1, true, [
            'page' => [
                'controller' => 'PromoListingPromos',
            ],
            'data' => [
                'listing_promo_group_id' => $promo_group_id,
            ],
        ]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);

        // Get the promos
        $promos = app(PromoRepository::class, ['wsuApi' => $wsuApi])->getPromoListingPromos($data);

        $this->assertCount(count($return['promotions']), $promos['promos']);
    }

    /**
     * @covers \App\Repositories\PromoRepository::getPromoListingPromos
     * @test
     */
    public function getting_promos_listing_as_grid_should_return_grid_array()
    {
        // Fake return
        $return = [
            'promotions' => [],
        ];

        // Create a fake data request
        $data = app(Page::class)->create(1, true, [
            'page' => [
                'controller' => 'PromoListingPromos',
            ],
            'data' => [
                'grid_promo_group_id' => $this->faker->numberbetween(1, 3),
            ],
        ]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);

        // Get the promos
        $promos = app(PromoRepository::class, ['wsuApi' => $wsuApi])->getPromoListingPromos($data);
        $this->assertTrue(is_array($promos));
    }

    /**
     * @covers \App\Repositories\PromoRepository::getPromoListingPromos
     * @test
     */
    public function getting_promos_listing_with_promotion_view_boolean_true_should_return_with_view_link()
    {
        $promo_group_id = $this->faker->numberbetween(1, 3);

        // Fake return
        $return['promotions'] = app(PromoListing::class)->create(5, false, [
            'promo_group_id' => $promo_group_id,
        ]);

        // Create a fake data request
        $data = app(Page::class)->create(1, true, [
            'page' => [
                'controller' => 'PromoListingPromos',
            ],
            'data' => [
                'listing_promo_group_id' => $promo_group_id,
                'promotion_view_boolean' => 'true',
            ],
        ]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);

        // Get the promos
        $promos = app(PromoRepository::class, ['wsuApi' => $wsuApi])->getPromoListingPromos($data);

        collect($promos['promos'])->each(function ($promo) {
            $expected = 'view/'.Str::slug($promo['title']).'-'.$promo['promo_item_id'];

            $this->assertEquals($expected, $promo['link']);
        });
    }

    /**
     * @covers \App\Repositories\PromoRepository::getPromoListingPromos
     * @test
     */
    public function getting_promos_listing_with_no_page_field_should_be_empty_array()
    {
        // Create a fake data request
        $data = app(Page::class)->create(1, true, [
            'page' => [
                'controller' => 'PromoListingPromos',
            ],
        ]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->never();

        // Get the promos
        $promos = app(PromoRepository::class, ['wsuApi' => $wsuApi])->getPromoListingPromos($data);
        $this->assertTrue(is_array($promos));
    }

    /**
     * @covers \App\Repositories\PromoRepository::getPromoView
     * @test
     */
    public function getting_single_promo_should_return_array()
    {
        $promo_return = app(PromoListing::class)->create(1, true);

        // Fake return
        $return = [
            'promotion' => $promo_return,
        ];

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.info', Mockery::type('array'))->once()->andReturn($return);


        // Get the promo
        $single_promo = app(PromoRepository::class, ['wsuApi' => $wsuApi])->getPromoView($this->faker->randomDigit);
        $promo['promotion'] = $single_promo['promo'];

        $this->assertEquals($promo, ['promotion' => $promo_return]);
    }

    /**
     * @covers \App\Repositories\PromoRepository::getBackToPromoListing
     * @test
     */
    public function getting_back_to_promo_list_url_should_return_url()
    {
        // The default path if no referer
        $url = app(PromoRepository::class)->getBackToPromoListing();
        $this->assertTrue($url == '');

        // If a referer is passed from a different domain
        $referer = $this->faker->url;
        $url = app(PromoRepository::class)->getBackToPromoListing($referer, 'http', 'wayne.edu', '/');
        $this->assertTrue($url == '');

        // If a referer is passed that is the same page we are on
        $referer = $this->faker->url;
        $parsed = parse_url($referer);
        $url = app(PromoRepository::class)->getBackToPromoListing($referer, $parsed['scheme'], $parsed['host'], $parsed['path']);
        $this->assertTrue($url == '');

        // If referer is passed from the same domain that the site is on
        $referer = $this->faker->url;
        $parsed = parse_url($referer);
        $url = app(PromoRepository::class)->getBackToPromoListing($referer, $parsed['scheme'], $parsed['host'], $this->faker->word);
        $this->assertEquals($referer, $url);
    }
}
