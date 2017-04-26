<?php

namespace Tests\App\Repositories;

use Tests\TestCase;
use Mockery as Mockery;

class EventRepositoryTest extends TestCase
{
    /**
     * @covers App\Repositories\EventRepository::__construct
     * @covers App\Repositories\EventRepository::getEvents
     * @test
     */
    public function getting_events_with_api_error_should_return_empty_array()
    {
        // Fake return
        $return = app('Factories\ApiError')->create(1);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock('Waynestate\Api\Connector');
        $wsuApi->shouldReceive('sendRequest')->with('calendar.events.listing', Mockery::type('array'))->once()->andReturn($return);
        $wsuApi->shouldReceive('nextRequestProduction')->once();

        // Get the news
        $events = $this->app->build('App\Repositories\EventRepository', [$wsuApi])->getEvents($this->faker->randomDigit);

        // Make sure we have a blank news array
        $this->assertEquals($events, ['events' => []]);
    }
}
