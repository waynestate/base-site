<?php

namespace App\Repositories;

use Contracts\Repositories\SpotlightRepositoryContract;
use Illuminate\Cache\Repository;
use Waynestate\Api\Connector;
use Waynestate\Promotions\ParsePromos;

class SpotlightRepository implements SpotlightRepositoryContract
{
    /** @var Connector */
    protected $wsuApi;

    /** @var ParsePromos */
    protected $parsePromos;

    /** @var Repository */
    protected $cache;

    /**
     * Construct the repository.
     *
     * @param Connector $wsuApi
     * @param ParsePromos $parsePromos
     * @param Repository $cache
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
    public function getSpotlights(array $data)
    {
        $group_reference = [];

        // If there is an spotlight custom page field then inject it into the group reference
        if (!empty($data['data']['spotlight_promo_group_id']) && ! array_key_exists($data['data']['spotlight_promo_group_id'], $group_reference)) {
            $group_reference[$data['data']['spotlight_promo_group_id']] = 'spotlights';
        }

        $group_config = [];

        $params = [
            'method' => 'cms.promotions.listing',
            'promo_group_id' => array_keys($group_reference),
            'filename_url' => true,
            'is_active' => '1',
        ];

        $promos = $this->cache->remember($params['method'].md5(serialize($params)), config('cache.ttl'), function () use ($params) {
            return $this->wsuApi->sendRequest($params['method'], $params);
        });

        return $this->parsePromos->parse($promos, $group_reference, $group_config);
    }

    /**
     * {@inheritdoc}
     */
    public function getSpotlight($id)
    {
        $params = [
            'method' => 'cms.promotions.info',
            'promo_item_id' => $id,
            'filename_url' => true,
            'is_active' => '1',
        ];

        $promo = $this->cache->remember($params['method'].md5(serialize($params)), config('cache.ttl'), function () use ($params) {
            return $this->wsuApi->sendRequest($params['method'], $params);
        });

        $spotlight['spotlight'] = empty($promo['error']) ? $promo['promotion'] : [];

        return $spotlight;
    }

    /**
     * {@inheritdoc}
     */
    public function getBackToSpotlightsListing($referer = null, $scheme = null, $host = null, $uri = null)
    {
        // Make sure the referer is coming from the site we are currently on and not the current page
        if ($referer === null
            || $referer == $scheme.'://'.$host.$uri
            || strpos($referer, $host) === false
        ) {
            return '/spotlightlisting';
        }

        return $referer;
    }
}
