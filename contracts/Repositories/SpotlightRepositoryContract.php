<?php

namespace Contracts\Repositories;

interface SpotlightRepositoryContract
{
    /**
     * Get the spotlights listing.
     *
     * @return array
     */
    public function getSpotlights(array $data);

    /**
     * Get promotions for individual spotlights.
     *
     * @param $id
     * @return array
     */
    public function getSpotlight($id);

    /**
     * Go back to previous page.
     *
     * @param null $referer
     * @param null $scheme
     * @param null $host
     * @param null $uri
     * @return string
     */
    public function getBackToSpotlightsListing($referer = null, $scheme = null, $host = null, $uri = null);
}
