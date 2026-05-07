<?php

namespace Contracts\Repositories;

interface EventRepositoryContract
{
    /**
     * Get event listing.
     *
     * @param int $site_id The ID of the site for which events are being retrieved.
     * @param int $limit The maximum number of events to retrieve. Defaults to 4.
     * @param int $audience_id The ID of the audience to filter events by.
     * @param int $is_featured The value to filter events by.
     * @param int $featured_images_only The value to filter events by.
     *
     * @return array
     */
    public function getEvents(int $site_id, int $limit = 4, int $audience_id = null, int $is_featured = null, int $featured_images_only = null): array;

    /**
     * Retrieves a full listing of events associated with a specific site.
     *
     * @param  int  $site_id  The ID of the site for which events are being retrieved.
     * @param  int  $limit  The maximum number of events to retrieve. Defaults to 4.
     * @param  int  $audience_id  The ID of the audience to filter events by.
     * @param  int  $is_featured  The value to filter events by.
     * @param  int  $featured_images_only  The value to filter events by.
     * @return array  The list of events or other appropriate data structure.
     */
    public function getEventsFullListing(int $site_id, int $limit = 4, int $audience_id = null, int $is_featured = null, int $featured_images_only = null): array;
}
