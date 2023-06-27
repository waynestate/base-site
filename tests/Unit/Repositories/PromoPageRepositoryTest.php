<?php

namespace Tests\Unit\Repositories;

use App\Repositories\PromoPageRepository;
use Factories\Page;
use Factories\PromoPage;
use Factories\PromoPageWithOptions;
use Illuminate\Support\Str;
use Tests\TestCase;
use Mockery as Mockery;
use Waynestate\Api\Connector;

// Tests
// getting a list
// getting a grid
// getting a list with options
// id
// config
// excerpt
// single promo view
// columns
// description
// parse promo 
//
/*
    public function parsePromoJSON($data)
    public function getPromoPagePromos(array $data)
    public function changePromoItemDisplay($promos, $group_info)
    public function organizePromoItemsByOption(array $promos)
    public function getBackToPromoListing($referer = null, $scheme = null, $host = null, $uri = null)
 */

class PromoPageRepositoryTest extends TestCase
{
    /**
     * @covers \App\Repositories\PromoPageRepository::getPromoPagePromos
     * @test
     */
    /*
    public function getting_promo_page_as_listing_should_return_listing_array()
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
        $promos = app(PromoPageRepository::class, ['wsuApi' => $wsuApi])->getPromoListingPromos($data);

        $this->assertCount(count($return['promotions']), $promos['promos']);
    }

    /**
     * @covers \App\Repositories\PromoPageRepository::getPromoListingPromos
     * @test
     */
    /*
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
        $promos = app(PromoPageRepository::class, ['wsuApi' => $wsuApi])->getPromoListingPromos($data);

        collect($promos['promos'])->each(function ($promo) {
            $expected = 'view/'.Str::slug($promo['title']).'-'.$promo['promo_item_id'];

            $this->assertEquals($expected, $promo['link']);
        });
    }
     */

    /**
     * @covers \App\Repositories\PromoPageRepository::getPromoListingPromos
     * @test
     */
    /*
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
        $promos = app(PromoPageRepository::class, ['wsuApi' => $wsuApi])->getPromoListingPromos($data);
        $this->assertTrue(is_array($promos));
    }
    

    /**
     * @covers \App\Repositories\PromoPageRepository::getPromoView
     * @test
     */
    public function getting_single_promo_should_return_array()
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
        $single_promo = app(PromoPageRepository::class, ['wsuApi' => $wsuApi])->getPromoView($this->faker->randomDigit);
        $promo['promotion'] = $single_promo['promo'];

        $this->assertEquals($promo, ['promotion' => $promo_return]);
    }
     
    /**
     * @covers \App\Repositories\PromoPageRepository::getBackToPromoListing
     * @test
     */
    public function getting_back_to_promo_list_url_should_return_url()
    {
        // The default path if no referer
        $url = app(PromoPageRepository::class)->getBackToPromoListing();
        $this->assertTrue($url == '');

        // If a referer is passed from a different domain
        $referer = $this->faker->url;
        $url = app(PromoPageRepository::class)->getBackToPromoListing($referer, 'http', 'wayne.edu', '/');
        $this->assertTrue($url == '');

        // If a referer is passed that is the same page we are on
        $referer = $this->faker->url;
        $parsed = parse_url($referer);
        $url = app(PromoPageRepository::class)->getBackToPromoListing($referer, $parsed['scheme'], $parsed['host'], $parsed['path']);
        $this->assertTrue($url == '');

        // If referer is passed from the same domain that the site is on
        $referer = $this->faker->url;
        $parsed = parse_url($referer);
        $url = app(PromoPageRepository::class)->getBackToPromoListing($referer, $parsed['scheme'], $parsed['host'], $this->faker->word);
        $this->assertEquals($referer, $url);
    }
}
