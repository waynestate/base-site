<?php

namespace Contracts\Repositories;

interface SpotlightRepositoryContract
{
    /**
     * Get the spotlights listing.
     *
     * @return array
     */
    public function getSpotlights();
}
