<?php

namespace Styleguide\Repositories;

use App\Repositories\EventRepository as Repository;
use Factories\Event;
use Factories\EventFullListing;

class EventRepository extends Repository
{
    /**
     * {@inheritdoc}
     */
    public function getEvents($site_id, $limit = 4)
    {
        $events['events'] = app(Event::class)->create(5);

        // Put random stlyeguide dates in order
        if (!empty($events['events'])) {
            $events['events'] = collect($events['events'])->sortBy(function ($item, $key) {
                return $key;
            })->toArray();
        } else {
            $events = [];
        }

        return $events;
    }

    /**
     * {@inheritdoc}
     */
    public function getEventsFullListing($site_id, $limit = 4)
    {
        $events['events'] = [];
        $events_listing['events'] = app(EventFullListing::class)->create(4);

        if (!empty($events_listing['events'])) {
            $events['events'] = collect($events_listing['events'])
                ->map(function ($event) {
                    if (!empty($event['images'])) {
                        $event['display_image'] = collect($event['images'])->first();
                    } else {
                        $event['display_image']['full_url'] = "https://wayne.edu/opengraph/wsu-social-share-square.jpg";
                        $event['display_image']['description'] = "Event on wayne.edu";
                    }

                    return $event;
                })
                ->take($limit)
                ->toArray();
            return $events;
        }

        return $events;
    }
}
