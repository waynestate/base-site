<?php

namespace App\Repositories;

use Contracts\Repositories\EventRepositoryContract;
use Illuminate\Cache\Repository;
use Illuminate\Support\Str;
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
            'limit' => $limit,
            'end_date' => date('Y-m-d', strtotime('+6 month')),
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

    /**
     * {@inheritdoc}
     */
    public function getEventsFullListing($site_id, $limit = 4)
    {
        $params = [
            'method' => 'calendar.events.fulllisting',
            'site' => $site_id,
            'limit' => 50,
            'end_date' => $end_date ?? date('Y-m-d', strtotime('+6 month')),
        ];

        $events['events'] = $this->cache->remember($params['method'].md5(serialize($params)), config('cache.ttl'), function () use ($params, $limit) {
            $this->wsuApi->nextRequestProduction();

            $events_listing = $this->wsuApi->sendRequest($params['method'], $params);

            if (!empty($events_listing['events'])) {
                $events = collect($events_listing['events'])
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
                    ->groupBy('date')
                    ->toArray();
            }

            return $events ?? [];
        });

        return $events;
    }

    /**
     * {@inheritdoc}
     */
    public function getEventsByTitle($site_id, $titles, $limit = 4)
    {
        $params = [
            'method' => 'calendar.events.fulllisting',
            'site' => $site_id,
            'limit' => 100,
            'end_date' => date('Y-m-d', strtotime('+12 month')),
            'firstonly' => false,
        ];

        $events = $this->cache->remember($params['method'].md5(serialize($params)), config('cache.ttl'), function () use ($params, $titles, $limit) {
            $this->wsuApi->nextRequestProduction();

            $events_listing = $this->wsuApi->sendRequest($params['method'], $params);

            // If events are returned, group them by date and assign images for featured events
            if (!empty($events_listing['events'])) {
                $events_listing['events'] = collect($events_listing['events'])
                    ->map(function ($event) {
                        if (!empty($event['images'])) {
                            $event['display_image'] = collect($event['images'])->first();
                        } else {
                            $event['display_image']['full_url'] = 'https://wayne.edu/opengraph/wsu-social-share-square.jpg';
                            $event['display_image']['description'] = 'Event on wayne.edu';
                        }
                        return $event;
                    })->toArray();

                // Filter the expected events to only include those with the matching titles and unique event IDs
                $events['events'] = collect($events_listing['events'])->filter(function ($event) use ($titles) {
                    foreach ($titles as $title) {
                        if (Str::contains($event['title'], trim($title), ignoreCase: true)) {
                            return true;
                        }
                    }
                    return false;
                })->unique('event_id')->groupBy('date')->take($limit)->toArray();
            }

            return $events ?? [];
        });

        return $events;
    }
}
