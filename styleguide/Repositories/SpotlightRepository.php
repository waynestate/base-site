<?php

namespace Styleguide\Repositories;

use App\Repositories\SpotlightRepository as Repository;

class SpotlightRepository extends Repository
{
    /**
     * {@inheritdoc}
     */
    public function getSpotlights()
    {
        return [
            'spotlights' => app('Factories\Spotlight')->create(5)
        ];
    }
}
