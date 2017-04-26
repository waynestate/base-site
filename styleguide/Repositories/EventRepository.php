<?php

namespace Styleguide\Repositories;

use App\Repositories\EventRepository as Repository;

class EventRepository extends Repository
{
    /**
     * {@inheritdoc}
     */
    public function getEvents($site_id)
    {
        $events['events'] = app('Factories\Event')->create(4);

        return $events;
    }
}
