<?php

namespace Contracts\Repositories;

interface EventRepositoryContract
{
    /**
     * Get event listing.
     *
     * @return array
     */
    public function getEvents(int $site_id, int $limit = 4);

    /**
     * Retrieves a full listing of events associated with a specific site.
     *
     * @param  int  $site_id  The ID of the site for which events are being retrieved.
     * @param  int  $limit  The maximum number of events to retrieve. Defaults to 4.
     * @return mixed The list of events or other appropriate data structure.
     */
    public function getEventsFullListing(int $site_id, int $limit = 4);
}
