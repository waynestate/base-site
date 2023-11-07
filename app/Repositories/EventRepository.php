<?php

namespace App\Repositories;

use Contracts\Repositories\EventRepositoryContract;
use Illuminate\Cache\Repository;
use Waynestate\Api\Connector;
use Waynestate\Promotions\ParsePromos;

class EventRepository implements EventRepositoryContract
{
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
    public function getEvents($site_id, $limit = 4)
    {
        $params = [
            'method' => 'calendar.events.listing',
            'site' => $site_id,
            'limit' => $limit ?? 4,
            'end_date' => $end_date ?? date('Y-m-d', strtotime('+6 month')),
        ];

        $events['events'] = $this->cache->remember($params['method'].md5(serialize($params)), config('cache.ttl'), function () use ($params) {
            $this->wsuApi->nextRequestProduction();

            $events_listing = $this->wsuApi->sendRequest($params['method'], $params);

            if (!empty($events_listing['events'])) {
                $events_listing = collect($events_listing['events'])->groupBy('date')->toArray();
            } else {
                $events_listing = [];
            }

            return $events_listing;
        });

        return $events;
    }
}
