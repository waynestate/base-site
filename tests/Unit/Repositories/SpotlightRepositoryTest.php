<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use Mockery as Mockery;

class SpotlightRepositoryTest extends TestCase
{
    /**
     * @covers App\Repositories\SpotlightRepository::getSpotlights
     * @test
     */
    public function getting_spotlights_should_return_array()
    {
        // Fake return
        $return = [
            'spotlights' => [],
        ];

        // Create a fake data request
        $data = app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'SpotlightController',
            ],
            'data' => [
                'spotlight_promo_group_id' => $this->faker->numberbetween(1, 3),
            ],
        ]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock('Waynestate\Api\Connector');
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);

        // Get the spotlights
        $spotlights = app('App\Repositories\SpotlightRepository', ['wsuApi' => $wsuApi])->getSpotlights($data);
        $this->assertTrue(is_array($spotlights));
    }

    /**
     * @covers App\Repositories\SpotlightRepository::getSpotlight
     * @test
     */
    public function getting_spotlight_should_return_array()
    {
        $spotlight_return = app('Factories\Spotlight')->create(1, true);

        // Fake return
        $return = [
            'promotion' => $spotlight_return,
        ];

        // Mock the connector and set the return
        $wsuApi = Mockery::mock('Waynestate\Api\Connector');
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.info', Mockery::type('array'))->once()->andReturn($return);

        // Get the spotlight
        $spotlight = app('App\Repositories\SpotlightRepository', ['wsuApi' => $wsuApi])->getSpotlight($this->faker->randomDigit);

        $this->assertEquals($spotlight, ['spotlight' => $spotlight_return]);
    }

    /**
     * @covers App\Repositories\SpotlightRepository::getBackToSpotlightsListing
     * @test
     */
    public function getting_back_to_spotlight_list_url_should_return_url()
    {
        // The default path if no referer
        $url = app('App\Repositories\SpotlightRepository')->getBackToSpotlightsListing();
        $this->assertTrue($url == '/spotlights');

        // If a referer is passed from a different domain
        $referer = $this->faker->url;
        $url = app('App\Repositories\SpotlightRepository')->getBackToSpotlightsListing($referer, 'http', 'wayne.edu', '/');
        $this->assertTrue($url == '/spotlights');

        // If a referer is passed that is the same page we are on
        $referer = $this->faker->url;
        $parsed = parse_url($referer);
        $url = app('App\Repositories\SpotlightRepository')->getBackToSpotlightsListing($referer, $parsed['scheme'], $parsed['host'], $parsed['path']);
        $this->assertTrue($url == '/spotlights');

        // If referer is passed from the same domain that the site is on
        $referer = $this->faker->url;
        $parsed = parse_url($referer);
        $url = app('App\Repositories\SpotlightRepository')->getBackToSpotlightsListing($referer, $parsed['scheme'], $parsed['host'], $this->faker->word);
        $this->assertEquals($referer, $url);
    }
}

