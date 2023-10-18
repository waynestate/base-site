<?php

namespace Tests\Unit\Repositories;

use PHPUnit\Framework\Attributes\Test;
use App\Repositories\ModularPageRepository;
use Factories\Page;
use Factories\GenericPromo;
use Tests\TestCase;
use Mockery as Mockery;
use Waynestate\Api\Connector;

final class ModularPageRepositoryTest extends TestCase
{
    #[Test]
    public function modular_page_parse_json_returns_promos(): void
    {
        $promo_group_id = $this->faker->numberbetween(1, 3);

        // Fake return
        $return['promotions'] = app(GenericPromo::class)->create(5, false, [
            'promo_group_id' => $promo_group_id,
            'group' => [
                'promo_group_id' => $promo_group_id,
            ],
        ]);

        // Create a fake data request
        $data = app(Page::class)->create(1, true, [
            'page' => [
                'controller' => 'ModularPage',
            ],
            'data' => [
                'modular-accordion-1' => '{
"id":'. $promo_group_id .',
"config":"randomize|limit:20",
"columns":"",
"singlePromoView":"true",
"showExcerpt":"true",
"showDescription":"true",
}',
            ],
        ]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);

        // Run the promos through the repository
        $promos = app(ModularPageRepository::class, ['wsuApi' => $wsuApi])->getModularPromos($data);

        $this->assertCount(count($return['promotions']), $promos['accordion-1']);
    }

    /*
    #[Test]
    public function promo_page_parse_json_returns_promos_by_option(): void
    {
        $promo_group_id = $this->faker->numberbetween(1, 3);

        // Fake return
        $return['promotions'] = app(PromoPageWithOptions::class)->create(5, false, [
            'promo_group_id' => $promo_group_id,
        ]);

        // Create a fake data request
        $data = app(Page::class)->create(1, true, [
            'page' => [
                'controller' => 'PromoPagePromos',
            ],
            'data' => [
                'promoPage' => '{
"id":'. $promo_group_id .',
"config":"randomize|limit:20",
"columns":"",
"singlePromoView":"true",
"showExcerpt":"true",
"showDescription":"true",
}',
            ],
        ]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);

        // Group the fake return by option
        $return['promotions'] = collect($return['promotions'])->groupBy('option')->toArray();

        // Run the promos through the repository
        $promos = app(PromoPageRepository::class, ['wsuApi' => $wsuApi])->getPromoPagePromos($data);

        $this->assertCount(count($return['promotions']), $promos['promos']);
    }

    #[Test]
    public function promo_page_unset_excerpt(): void
    {
        $promo_group_id = $this->faker->numberbetween(1, 3);

        // Fake return
        $return['promotions'] = app(PromoPage::class)->create(5, false, [
            'promo_group_id' => $promo_group_id,
        ]);
        $return['promotions'] = array_values($return['promotions']);

        // Create a fake data request
        $data = app(Page::class)->create(1, true, [
            'page' => [
                'controller' => 'PromoPagePromos',
            ],
            'data' => [
                'promoPage' => '{
"id":'. $promo_group_id .',
"config":"randomize|limit:20",
"showExcerpt":"false",
}',
            ],
        ]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);

        // Run the promos through the repository
        $promos = app(PromoPageRepository::class, ['wsuApi' => $wsuApi])->getPromoPagePromos($data);

        // Excerpt array key should not exist
        $promos['promos'] = collect($promos['promos'])->map(function ($array) {
            return array_key_exists('excerpt', $array);
        });

        // Expected to match removed excerpt
        $return['promotions']  = collect($return['promotions'])->map(function ($array) {
            unset($array['excerpt']);
            return array_key_exists('excerpt', $array);
        });

        $this->assertEquals($return['promotions'], $promos['promos']);
    }

    #[Test]
    public function promo_page_unset_description(): void
    {
        $promo_group_id = $this->faker->numberbetween(1, 3);

        // Fake return
        $return['promotions'] = app(PromoPage::class)->create(5, false, [
            'promo_group_id' => $promo_group_id,
        ]);

        // Fake return starts at 1 for some reason
        $return['promotions'] = array_values($return['promotions']);

        // Create a fake data request
        $data = app(Page::class)->create(1, true, [
            'page' => [
                'controller' => 'PromoPagePromos',
            ],
            'data' => [
                'promoPage' => '{
"id":'. $promo_group_id .',
"config":"randomize|limit:20",
"showDescription":"false",
}',
            ],
        ]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);

        // Run the promos through the repository
        $promos = app(PromoPageRepository::class, ['wsuApi' => $wsuApi])->getPromoPagePromos($data);

        // Excerpt array key should not exist
        $promos['promos'] = collect($promos['promos'])->map(function ($array) {
            return array_key_exists('description', $array);
        });

        // Expected to match removed excerpt
        $return['promotions']  = collect($return['promotions'])->map(function ($array) {
            unset($array['description']);
            return array_key_exists('description', $array);
        });

        $this->assertEquals($return['promotions'], $promos['promos']);
    }

    #[Test]
    public function promo_page_set_single_promo_view(): void
    {
        $promo_group_id = $this->faker->numberbetween(1, 3);

        // Fake return
        $return['promotions'] = app(PromoPage::class)->create(5, false, [
            'promo_group_id' => $promo_group_id,
        ]);

        // Fake return starts at 1 for some reason
        $return['promotions'] = array_values($return['promotions']);

        // Create a fake data request
        $data = app(Page::class)->create(1, true, [
            'page' => [
                'controller' => 'PromoPagePromos',
            ],
            'data' => [
                'promoPage' => '{
"id":'. $promo_group_id .',
"config":"randomize|limit:20",
"singlePromoView":"true",
}',
            ],
        ]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);

        // Run the promos through the repository
        $promos = app(PromoPageRepository::class, ['wsuApi' => $wsuApi])->getPromoPagePromos($data);

        // Test first item
        $item = current($promos['promos']);

        $this->assertTrue(str_contains($item['link'], 'view/'));
    }

    #[Test]
    public function promo_page_set_columns(): void
    {
        $promo_group_id = $this->faker->numberbetween(1, 3);

        // Fake return
        $return['promotions'] = app(PromoPage::class)->create(5, false, [
            'promo_group_id' => $promo_group_id,
        ]);

        // Fake return starts at 1 for some reason
        $return['promotions'] = array_values($return['promotions']);

        // Create a fake data request
        $data = app(Page::class)->create(1, true, [
            'page' => [
                'controller' => 'PromoPagePromos',
            ],
            'data' => [
                'promoPage' => '{
"id":'. $promo_group_id .',
"config":"randomize|limit:20",
"columns":"2"
}',
            ],
        ]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);

        // Run the promos through the repository
        $promos = app(PromoPageRepository::class, ['wsuApi' => $wsuApi])->getPromoPagePromos($data);

        $this->assertTrue(!empty($promos['template']['columns']));
    }

    #[Test]
    public function promo_page_set_config(): void
    {
        $promo_group_id = $this->faker->numberbetween(1, 3);

        // Fake return
        $return['promotions'] = app(PromoPage::class)->create(5, false, [
            'promo_group_id' => $promo_group_id,
        ]);

        // Fake return starts at 1 for some reason
        $return['promotions'] = array_values($return['promotions']);

        // Create a fake data request
        $data = app(Page::class)->create(1, true, [
            'page' => [
                'controller' => 'PromoPagePromos',
            ],
            'data' => [
                'promoPage' => '{
"id":'. $promo_group_id .',
"config":"limit:2",
}',
            ],
        ]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);

        // Run the promos through the repository
        $promos = app(PromoPageRepository::class, ['wsuApi' => $wsuApi])->getPromoPagePromos($data);

        $this->assertCount(2, $promos['promos']);
    }


    #[Test]
    public function promo_page_with_no_page_field_should_be_empty_array(): void
    {
        // Create a fake data request
        $data = app(Page::class)->create(1, true, [
            'page' => [
                'controller' => 'PromoPagePromos',
            ],
        ]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->never();

        // Get the promos
        $promos = app(PromoPageRepository::class, ['wsuApi' => $wsuApi])->getPromoPagePromos($data);
        $this->assertTrue(is_array($promos));
    }


    #[Test]
    public function getting_single_promo_should_return_array(): void
    {
        $promo_return = app(PromoPage::class)->create(1, true);

        // Fake return
        $return = [
            'promotion' => $promo_return,
        ];

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.info', Mockery::type('array'))->once()->andReturn($return);


        // Get the promo
        $single_promo = app(PromoPageRepository::class, ['wsuApi' => $wsuApi])->getPromoView($this->faker->randomDigit());
        $promo['promotion'] = $single_promo['promo'];

        $this->assertEquals($promo, ['promotion' => $promo_return]);
    }

    #[Test]
    public function back_to_promo_page_should_return_url(): void
    {
        // The default path if no referer
        $url = app(PromoPageRepository::class)->getBackToPromoPage();
        $this->assertTrue($url == '');

        // If a referer is passed from a different domain
        $referer = $this->faker->url();
        $url = app(PromoPageRepository::class)->getBackToPromoPage($referer, 'http', 'wayne.edu', '/');
        $this->assertTrue($url == '');

        // If a referer is passed that is the same page we are on
        $referer = $this->faker->url();
        $parsed = parse_url($referer);
        $url = app(PromoPageRepository::class)->getBackToPromoPage($referer, $parsed['scheme'], $parsed['host'], $parsed['path']);
        $this->assertTrue($url == '');

        // If referer is passed from the same domain that the site is on
        $referer = $this->faker->url();
        $parsed = parse_url($referer);
        $url = app(PromoPageRepository::class)->getBackToPromoPage($referer, $parsed['scheme'], $parsed['host'], $this->faker->word());
        $this->assertEquals($referer, $url);
    }
     */
}
