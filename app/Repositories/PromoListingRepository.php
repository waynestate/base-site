<?php

namespace App\Repositories;

use Contracts\Repositories\PromoListingRepositoryContract;
use Illuminate\Cache\Repository;
use Waynestate\Api\Connector;
use Waynestate\Promotions\ParsePromos;

class PromoListingRepository implements PromoListingRepositoryContract
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
    public function getPromoListingPromos(array $data, $limit = 75)
    {
        $group_reference = [];
        
        if (empty($data['data']['listing_promo_group_id'])) {
            return ['listing_promos' => []];
        }

        // If there is an grid custom page field then inject it into the group reference
        $group_reference[$data['data']['listing_promo_group_id']] = 'listing_promos';

        $group_config = [
            'listing_promos' => 'limit:' . $limit,
        ];

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
}
