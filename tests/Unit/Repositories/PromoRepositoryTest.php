<?php

namespace Tests\App\Repositories;

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
        $data = app('Factories\Page')->create(1, [
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
    public function subsite_using_main_config()
    {
        // Fake return
        $return = [
            'promotions' => [
                [
                    'promo_item_id' => 1,
                    'promo_group_id' => 3,
                ],
                [
                    'promo_item_id' => 2,
                    'promo_group_id' => 3,
                ],
                [
                    'promo_item_id' => 3,
                    'promo_group_id' => 2,
                ],
            ],
        ];

        // Create a fake data request
        $data = app('Factories\Page')->create(1, [
            'site' => [
                'id' => 2,
                'parent' => [
                    'id' => 1,
                ],
            ],
        ]);

        // Build the config
        config(['base.global_promos' => [
            'main' => [
                'contact' => [
                    'id' => 1,
                    'config' => 'limit:1',
                ],
                'social' => [
                    'id' => 2,
                    'config' => 'limit:1',
                ],
            ],
            'subsites' => [
                $data['site']['id'] => [
                    'contact' => [
                        'id' => 3,
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
        $this->assertCount(1, $promos['social']);
    }

    /**
     * @covers App\Repositories\PromoRepository::__construct
     * @covers App\Repositories\PromoRepository::getRequestData
     * @test
     */
    public function subsite_using_main_contact_footer()
    {
        // Fake return
        $return = [
            'promotions' => [
                [
                    'promo_item_id' => 1,
                    'promo_group_id' => 1,
                ],
            ],
        ];

        // Create a fake data request
        $data = app('Factories\Page')->create(1, [
            'site' => [
                'id' => 2,
                'parent' => [
                    'id' => 1,
                ],
            ],
        ]);

        // Build the config
        config(['base.global_promos' => [
            'main' => [
                'contact' => [
                    'id' => 1,
                    'config' => 'limit:1',
                ],
            ],
            'subsites' => [
                $data['site']['id'] => [
                    'contact' => [
                        'id' => null,
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
        $promos = app('App\Repositories\PromoRepository', ['wsuApi' => $wsuApi])->getHomepagePromos();

        $this->assertTrue(is_array($promos));
    }
}
