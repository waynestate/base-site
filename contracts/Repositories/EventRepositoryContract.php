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
}
