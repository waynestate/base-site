<?php

namespace Tests\App\Repositories;

use Tests\TestCase;
use Mockery as Mockery;

class PromoHomepageRepositoryTest extends TestCase
{
    /**
     * @covers App\Repositories\PromoHomepageRepository::get
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
        $promos = app('App\Repositories\PromoHomepageRepository', ['wsuApi' => $wsuApi])->get();

        $this->assertTrue(is_array($promos));
    }
}
