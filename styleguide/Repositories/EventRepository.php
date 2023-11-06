<?php

namespace Styleguide\Repositories;

use App\Repositories\EventRepository as Repository;
use Factories\Event;

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
}
