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
        return [
            'events' => app('Factories\Event')->create(4),
        ];
    }
}
