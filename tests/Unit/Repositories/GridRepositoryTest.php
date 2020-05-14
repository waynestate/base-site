<?php

namespace Tests\Unit\Repositories;

use Tests\TestCase;
use Mockery as Mockery;

class GridRepositoryTest extends TestCase
{
    /**
     * @covers App\Repositories\GridRepository::__construct
     * @covers App\Repositories\GridRepository::getGridPromos
     * @test
     */
    public function getting_grid_promos()
    {
        // Fake return
        $return = [
            'promotions' => app('Factories\Grid')->create(5),
        ];

        // Create a fake data request
        $data = app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'GridController',
            ],
            'data' => [
                'grid_promo_group_id' => current($return['promotions'])['promo_group_id'],
            ],
        ]);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock('Waynestate\Api\Connector');
        $wsuApi->shouldReceive('sendRequest')->with('cms.promotions.listing', Mockery::type('array'))->once()->andReturn($return);

        // Get the promos
        $promos = app('App\Repositories\GridRepository', ['wsuApi' => $wsuApi])->getGridPromos($data);

        $this->assertCount(count($return['promotions']), $promos['grid_promos']);
    }

    /**
     * @covers App\Repositories\GridRepository::__construct
     * @covers App\Repositories\GridRepository::getGridPromos
     * @test
     */
    public function getting_grid_promos_without_custom_page_field()
    {
        // Fake return
        $return = [
            'promotions' => app('Factories\Grid')->create(5),
        ];

        // Create a fake data request
        $data = app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'GridController',
            ],
            'data' => [
                'grid_promo_group_id' => null,
            ],
        ]);

        // Get the promos
        $promos = app('App\Repositories\GridRepository')->getGridPromos($data);

        $this->assertEquals([], $promos['grid_promos']);
    }
}
