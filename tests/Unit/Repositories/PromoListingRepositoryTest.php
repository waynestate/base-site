<?php

namespace Tests\Unit\Repositories;

use App\Repositories\PromoListingRepository;
use Factories\Page;
use Factories\PromoListing;
use Tests\TestCase;
use Mockery as Mockery;
use Waynestate\Api\Connector;

class PromoListingRepositoryTest extends TestCase
{
    /**
     * @covers \App\Repositories\PromoListingRepository::getPromoListingPromos
     * @test
     */
    public function getting_promos_should_return_array()
    {
        // Fake return
        $return = [
            'promos' => [],
        ];

        // Create a fake data request
        $data = app(Page::class)->create(1, true, [
            'page' => [
                'controller' => 'PromoListingPromos',
            ],
            'data' => [
                'listing_promo_group_id' => $this->faker->numberbetween(1, 3),
            ],
        ]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);

        // Get the promos
        $promos = app(PromoListingRepository::class, ['wsuApi' => $wsuApi])->getPromoListingPromos($data);
        $this->assertTrue(is_array($promos));
    }

    /**
     * @covers \App\Repositories\PromoListingRepository::getPromoView
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
        $single_promo = app(PromoListingRepository::class, ['wsuApi' => $wsuApi])->getPromoView($this->faker->randomDigit);
        $promo['promotion'] = $single_promo['promo'];

        $this->assertEquals($promo, ['promotion' => $promo_return]);
    }

    /**
     * @covers \App\Repositories\PromoListingRepository::getBackToPromoListing
     * @test
     */
    public function getting_back_to_promo_list_url_should_return_url()
    {
        // The default path if no referer
        $url = app(PromoListingRepository::class)->getBackToPromoListing();
        $this->assertTrue($url == '');

        // If a referer is passed from a different domain
        $referer = $this->faker->url;
        $url = app(PromoListingRepository::class)->getBackToPromoListing($referer, 'http', 'wayne.edu', '/');
        $this->assertTrue($url == '');

        // If a referer is passed that is the same page we are on
        $referer = $this->faker->url;
        $parsed = parse_url($referer);
        $url = app(PromoListingRepository::class)->getBackToPromoListing($referer, $parsed['scheme'], $parsed['host'], $parsed['path']);
        $this->assertTrue($url == '');

        // If referer is passed from the same domain that the site is on
        $referer = $this->faker->url;
        $parsed = parse_url($referer);
        $url = app(PromoListingRepository::class)->getBackToPromoListing($referer, $parsed['scheme'], $parsed['host'], $this->faker->word);
        $this->assertEquals($referer, $url);
    }
}
