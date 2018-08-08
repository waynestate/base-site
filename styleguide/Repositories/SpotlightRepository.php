<?php

namespace App\Repositories;

use App\Repositories\SpotlightRepository as Repository;

class SpotlightRepository extends Repository
{
    /**
     * {@inheritdoc}
     */
    public function getSpotlights()
    {
        return ['spotlights' => []];
    }
}
