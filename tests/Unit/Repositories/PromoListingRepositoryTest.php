<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use Mockery as Mockery;

class PromoListingRepositoryTest extends TestCase
{
    /**
     * @covers App\Repositories\PromoListingRepository::getPromoListingPromos
     * @test
     */
    public function getting_promos_should_return_array()
    {
        // Fake return
        $return = [
            'promos' => [],
        ];

        // Create a fake data request
        $data = app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'PromoListingPromos',
            ],
            'data' => [
                'listing_promo_group_id' => $this->faker->numberbetween(1, 3),
            ],
        ]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock('Waynestate\Api\Connector');
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);

        // Get the promos
        $promos = app('App\Repositories\PromoListingRepository', ['wsuApi' => $wsuApi])->getPromoListingPromos($data);
        $this->assertTrue(is_array($promos));
    }

    /**
     * @covers App\Repositories\PromoListingRepository::getPromoView
     * @test
     */
    public function getting_single_promo_should_return_array()
    {
        $promo_return = app('Factories\PromoListing')->create(1, true);

        // Fake return
        $return = [
            'promo' => $promo_return,
        ];

        // Mock the connector and set the return
        $wsuApi = Mockery::mock('Waynestate\Api\Connector');
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.info', Mockery::type('array'))->once()->andReturn($return);

        // Get the promo
        $promo = app('App\Repositories\PromoListingRepository', ['wsuApi' => $wsuApi])->getPromoView($this->faker->randomDigit);

        $this->assertEquals($promo, ['promo' => $promo_return]);
    }

    /**
     * @covers App\Repositories\PromoListingRepository::getBackToPromoListing
     * @test
     */
    public function getting_back_to_promo_list_url_should_return_url()
    {
        // The default path if no referer
        $url = app('App\Repositories\PromoListingRepository')->getBackToPromoListing();
        $this->assertTrue($url == '');

        // If a referer is passed from a different domain
        $referer = $this->faker->url;
        $url = app('App\Repositories\PromoListingRepository')->getBackToPromoListing($referer, 'http', 'wayne.edu', '/');
        $this->assertTrue($url == '');

        // If a referer is passed that is the same page we are on
        $referer = $this->faker->url;
        $parsed = parse_url($referer);
        $url = app('App\Repositories\PromoListingRepository')->getBackToPromoListing($referer, $parsed['scheme'], $parsed['host'], $parsed['path']);
        $this->assertTrue($url == '');

        // If referer is passed from the same domain that the site is on
        $referer = $this->faker->url;
        $parsed = parse_url($referer);
        $url = app('App\Repositories\PromoListingRepository')->getBackToPromoListing($referer, $parsed['scheme'], $parsed['host'], $this->faker->word);
        $this->assertEquals($referer, $url);
    }
}
