<?php

namespace Contracts\Repositories;

interface EventRepositoryContract
{
    /**
     * Get event listing.
     *
     * @param int $site_id
     * @return array
     */
    public function getEvents($site_id);

    /**
     * Get full event listing.
     *
     * @param int $site_id
     * @return array
     */
    public function getEventsFullListing($site_id);

    /**
     * Get event listing filtered by title.
     *
     * @param int $site_id
     * @param array $titles
     * @param int $limit
     * @return array
     */
    public function getEventsByTitle($site_id, $titles, $limit);
}
