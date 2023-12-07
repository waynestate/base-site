<?php

namespace Tests\Unit\Repositories;

use PHPUnit\Framework\Attributes\Test;
use App\Repositories\PromoRepository;
use Factories\Page;
use Factories\GenericPromo;
use Tests\TestCase;
use Mockery as Mockery;
use Waynestate\Api\Connector;

final class PromoRepositoryTest extends TestCase
{
    #[Test]
    public function subsite_overriding_main_contact_social_and_under_menu(): void
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

    #[Test]
    public function subsite_using_main_contact_social_and_under_menu(): void
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

    #[Test]
    public function subsite_contact_merging_with_main_contact_and_under_menu(): void
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

    #[Test]
    public function subsite_contact_merging_with_no_main_contact(): void
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

    #[Test]
    public function subsite_under_menu_merging_with_no_main_under_menu(): void
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

    #[Test]
    public function getting_single_promo_should_return_array(): void
    {
        $promo_return = app(GenericPromo::class)->create(1, true);

        // Fake return
        $return = [
            'promotion' => $promo_return,
        ];

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.info', Mockery::type('array'))->once()->andReturn($return);


        // Get the promo
        $single_promo = app(PromoRepository::class, ['wsuApi' => $wsuApi])->getPromoView($this->faker->randomDigit());
        $promo['promotion'] = $single_promo['promo'];

        $this->assertEquals($promo, ['promotion' => $promo_return]);
    }

    #[Test]
    public function back_to_promo_page_should_return_url(): void
    {
        // The default path if no referer
        $url = app(PromoRepository::class)->getBackToPromoPage();
        $this->assertTrue($url == '');

        // If a referer is passed from a different domain
        $referer = $this->faker->url();
        $url = app(PromoRepository::class)->getBackToPromoPage($referer, 'http', 'wayne.edu', '/');
        $this->assertTrue($url == '');

        // If a referer is passed that is the same page we are on
        $referer = $this->faker->url();
        $parsed = parse_url($referer);
        $url = app(PromoRepository::class)->getBackToPromoPage($referer, $parsed['scheme'], $parsed['host'], $parsed['path']);
        $this->assertTrue($url == '');

        // If referer is passed from the same domain that the site is on
        $referer = $this->faker->url();
        $parsed = parse_url($referer);
        $url = app(PromoRepository::class)->getBackToPromoPage($referer, $parsed['scheme'], $parsed['host'], $this->faker->word());
        $this->assertEquals($referer, $url);
    }

    #[Test]
    public function restrict_rotating_hero(): void
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

        // Build the config
        config(['base.global' => [
            'all' => [
                'promos' => [
                    'hero' => [
                        'id' => null,
                        'config' => '|limit:1',
                    ],
                ],
            ],
        ]]);

        config(['base.hero_rotating_controllers' => ['ChildpageController']]);
        config(['base.hero_rotating_limit' => 3]);

        // Create a fake data request
        $data = app(Page::class)->create(1, true, [
            'page' => [
                'controller' => 'ChildpageController',
            ],
        ]);

        // Get the global promos config
        $config = config('base.global');

        // Set all the groups
        $groups = $config['all']['promos'];

        $group_config = collect($groups)->mapWithKeys(function ($group, $name) use ($config, $data) {
            $value = !empty($group['config']) ? $group['config'] : null;
            return [$name => str_replace('{$page_id}', $data['page']['id'], $value)];
        })->reject(function ($value) {
            return empty($value);
        })->toArray();

        if (in_array($data['page']['controller'], config('base.hero_rotating_controllers'))) {
            $group_config = str_replace('|limit:1', '|limit:'.config('base.hero_rotating_limit'), $group_config);
        }

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);

        // Get the promos
        $promos = app(PromoRepository::class, ['wsuApi' => $wsuApi])->getRequestData($data);

        $this->assertEquals($group_config['hero'], '|limit:'.config('base.hero_rotating_limit'));
        $this->assertTrue((in_array($data['page']['controller'], config('base.hero_rotating_controllers'))));
    }
}
