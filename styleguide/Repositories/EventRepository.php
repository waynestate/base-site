<?php

namespace Styleguide\Repositories;

use App\Repositories\EventRepository as Repository;
use Factories\Event;

class EventRepository extends Repository
{
    /**
     * {@inheritdoc}
     */
    public function getEvents($site_id)
    {
        return [
            'events' => app(Event::class)->create(4),
        ];
    }
}
