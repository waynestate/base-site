<?php

namespace Tests\Unit\Repositories;

use PHPUnit\Framework\Attributes\Test;
use App\Repositories\EventRepository;
use Illuminate\Support\Str;
use Factories\ApiError;
use Factories\Event;
use Factories\EventByTitle;
use Factories\EventFullListing;
use Factories\EventFullListingNoImage;
use Tests\TestCase;
use Mockery as Mockery;
use Waynestate\Api\Connector;

final class EventRepositoryTest extends TestCase
{
    #[Test]
    public function getting_events_with_api_error_should_return_empty_array(): void
    {
        // Fake return
        $return = app(ApiError::class)->create(1, true);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('calendar.events.listing', Mockery::type('array'))->once()->andReturn($return);
        $wsuApi->shouldReceive('nextRequestProduction')->once();

        // Get the events
        $events = app(EventRepository::class, ['wsuApi' => $wsuApi])->getEvents($this->faker->randomDigit());

        // Make sure we have a blank events array
        $this->assertEquals($events, ['events' => []]);
    }

    #[Test]
    public function getting_events_grouped_by_date(): void
    {
        // Expected events to be returned
        $expected = app(Event::class)->create(2);

        // Maniuplate events to mimic the API return since they aren't grouped yet
        $return['events'] = collect($expected)->flatten(1)->toArray();

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('calendar.events.listing', Mockery::type('array'))->once()->andReturn($return);
        $wsuApi->shouldReceive('nextRequestProduction')->once();

        // Get the events
        $events = app(EventRepository::class, ['wsuApi' => $wsuApi])->getEvents($this->faker->randomDigit());

        $this->assertEquals($expected, $events['events']);
    }

    #[Test]
    public function getting_events_full_listing(): void
    {
        // Expected events to be returned
        $return['events'] = app(EventFullListing::class)->create(4);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('calendar.events.fulllisting', Mockery::type('array'))->once()->andReturn($return);
        $wsuApi->shouldReceive('nextRequestProduction')->once();

        // Get the events
        $events = app(EventRepository::class, ['wsuApi' => $wsuApi])->getEventsFullListing($this->faker->randomDigit());

        $this->assertEquals($return, $events);
    }

    #[Test]
    public function getting_events_full_listing_missing_image(): void
    {
        // Expected events to be returned
        $noimage['events'] = app(EventFullListingNoImage::class)->create(1);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('calendar.events.fulllisting', Mockery::type('array'))->once()->andReturn($noimage);
        $wsuApi->shouldReceive('nextRequestProduction')->once();

        // Get the events
        $events = app(EventRepository::class, ['wsuApi' => $wsuApi])->getEventsFullListing($this->faker->randomDigit());
        $event = collect($events['events'])->first();

        $this->assertTrue(!empty($event['display_image']['full_url']));
        $this->assertTrue(!empty($event['display_image']['description']));
    }

    #[Test]
    public function getting_events_by_title_should_only_return_events_matching_string_array(): void
    {
        // Create events
        $return['events'] = collect(app(EventByTitle::class)->create(2))->flatten(1)->toArray();

        // Get the titles from the events
        $titles = collect($return['events'])->filter(function ($value) {
            return $value['title'];
        })->pluck('title')->take(2)->toArray();

        // Get the expected events filtered by title
        $expected['events'] = collect($return['events'])->filter(function ($event) use ($titles) {
            foreach ($titles as $title) {
                if (Str::contains($event['title'], trim($title), ignoreCase: true)) {
                    return true;
                }
            }
            return false;
        })->unique('event_id')->groupBy('date')->take(4)->toArray();

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('calendar.events.fulllisting', Mockery::type('array'))->once()->andReturn($return);
        $wsuApi->shouldReceive('nextRequestProduction')->once();

        // Get the events
        $events = app(EventRepository::class, ['wsuApi' => $wsuApi])->getEventsByTitle($this->faker->randomDigit(), $titles);

        $this->assertEquals($expected, $events);
    }

    #[Test]
    public function getting_events_by_title_with_no_titles_should_return_empty_array(): void
    {
        // Create events
        $return['events'] = app(EventByTitle::class)->create(4);

        $titles = [];

        // Get the expected events filtered by title
        $expected['events'] = [];

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('calendar.events.fulllisting', Mockery::type('array'))->once()->andReturn($return);
        $wsuApi->shouldReceive('nextRequestProduction')->once();

        // Get the events
        $events = app(EventRepository::class, ['wsuApi' => $wsuApi])->getEventsByTitle($this->faker->randomDigit(), $titles);

        $this->assertEquals($expected, $events);
    }

    #[Test]
    public function getting_events_by_title_should_return_unique_events(): void
    {
        // Create a set of duplicate events
        $dupe['events'] = app(EventByTitle::class)->create(2, false, [
            'event_id' => 100,
            'title' => 'Class registration',
        ]);
        $duplicate['events'] = app(EventByTitle::class)->create(2, false, [
            'event_id' => 200,
            'title' => 'A high priority meeting',
        ]);

        // Merge the duplicate events
        $return['events'] = collect($dupe['events'])->merge($duplicate['events'])->flatten(1)->toArray();

        // Get the titles from the events
        $titles = collect($return['events'])->filter(function ($value) {
            return $value['title'];
        })->pluck('title')->take(2)->toArray();

        // Get the expected events filtered by title
        $expected['events'] = collect($return['events'])->filter(function ($event) use ($titles) {
            foreach ($titles as $title) {
                if (Str::contains($event['title'], trim($title), ignoreCase: true)) {
                    return true;
                }
            }
            return false;
        })->unique('event_id')->groupBy('date')->take(4)->toArray();

        // Mock the connector and set the return
        $wsuApi = Mockery::mock(Connector::class);
        $wsuApi->shouldReceive('sendRequest')->with('calendar.events.fulllisting', Mockery::type('array'))->once()->andReturn($return);
        $wsuApi->shouldReceive('nextRequestProduction')->once();

        // Get the events by title
        $events = app(EventRepository::class, ['wsuApi' => $wsuApi])->getEventsByTitle($this->faker->randomDigit(), $titles);

        $this->assertEquals($expected, $events);

        // Assert that each event in the returned events is unique
        $event_ids = collect($events['events'])->flatten(1)->pluck('event_id')->toArray();
        $expected_event_ids = collect($expected['events'])->flatten(1)->pluck('event_id')->toArray();

        $this->assertEquals($expected_event_ids, $event_ids);
    }
}
