<?php

namespace Styleguide\Repositories;

use App\Repositories\SpotlightRepository as Repository;

class SpotlightRepository extends Repository
{
    /**
     * {@inheritdoc}
     */
    public function getSpotlights(array $data)
    {
        return [
            'spotlights' => app('Factories\Spotlight')->create(12),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getSpotlight($id)
    {
        return [
            'spotlight' => app('Factories\Spotlight')->create(1, true),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getBackToSpotlightsListing($referer = null, $scheme = null, $host = null, $uri = null)
    {
        return '/styleguide/spotlights';
    }
}
