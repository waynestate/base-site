<?php

namespace App\Repositories;

use Contracts\Repositories\EventRepositoryContract;
use Illuminate\Cache\Repository;
use Waynestate\Api\Connector;
use Waynestate\Promotions\ParsePromos;
use App\Traits\StaleCache;
use App\Traits\FiltersExpiredItems;

class EventRepository implements EventRepositoryContract
{
    use StaleCache;
    use FiltersExpiredItems;

    /** @var Connector */
    protected $wsuApi;

    /** @var ParsePromos */
    protected $parsePromos;

    /** @var Repository */
    protected $cache;

    /**
     * Construct the repository.
     */
    public function __construct(Connector $wsuApi, ParsePromos $parsePromos, Repository $cache)
    {
        $this->wsuApi = $wsuApi;
        $this->parsePromos = $parsePromos;
        $this->cache = $cache;
    }

    /**
     * {@inheritdoc}
     */
    public function getEvents(int $site_id, int $limit = 4, ?int $audience_id = null, ?int $is_featured = null, ?int $featured_images_only = null): array
    {
        $params = [
            'method' => 'calendar.events.listing',
            'site' => $site_id,
            'limit' => $limit,
            'end_date' => date('Y-m-d', strtotime('+6 month')),
        ];

        // Cache the raw list only — grouping and expiry filtering must run on every
        // call (fresh or stale), not just when the API is actually reached.
        $events_listing = $this->rememberWithFallback($params['method'].md5(serialize($params)), config('cache.ttl'), function () use ($params) {
            $this->wsuApi->nextRequestProduction();

            $response = $this->wsuApi->sendRequest($params['method'], $params);

            return !empty($response['events']) ? $response['events'] : [];
        });

        $events['events'] = collect($this->filterExpiredItems($events_listing, ['date']))
            ->groupBy('date')
            ->toArray();

        return $events;
    }

    /**
     * {@inheritdoc}
     */
    public function getEventsFullListing(int $site_id, int $limit = 4, ?int $audience_id = null, ?int $is_featured = null, ?int $featured_images_only = null): array
    {
        $params = [
            'method' => 'calendar.events.fulllisting',
            'site' => $site_id,
            'limit' => 50,
            'end_date' => date('Y-m-d', strtotime('+6 month')),
        ];

        // Cache the raw list only — the image-fallback map, expiry filter, and
        // limit must run on every call (fresh or stale), not just when the API
        // is actually reached.
        $events_listing = $this->rememberWithFallback($params['method'].md5(serialize($params)), config('cache.ttl'), function () use ($params) {
            $this->wsuApi->nextRequestProduction();

            $response = $this->wsuApi->sendRequest($params['method'], $params);

            return !empty($response['events']) ? $response['events'] : [];
        });

        $events['events'] = collect($this->filterExpiredItems($events_listing, ['end_date', 'repeat_end_date'], false))
            ->map(function ($event) {
                if (!empty($event['images'])) {
                    $event['display_image'] = collect($event['images'])->first();
                } else {
                    $event['display_image']['full_url'] = 'https://wayne.edu/opengraph/wsu-social-share-square.jpg';
                    $event['display_image']['description'] = 'Event on wayne.edu';
                }

                return $event;
            })
            ->take($limit)
            ->toArray();

        return $events;
    }
}
