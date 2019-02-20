<?php

namespace App\Repositories;

use Contracts\Repositories\GridRepositoryContract;
use Illuminate\Cache\Repository;
use Waynestate\Api\Connector;
use Waynestate\Promotions\ParsePromos;

class GridRepository implements GridRepositoryContract
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
    public function getGridPromos(array $data, $limit = 75)
    {
        $group_reference = [];

        // If there is an grid custom page field then inject it into the group reference
        if (!empty($data['data']['grid_promo_group_id'])) {
            $group_reference[$data['data']['grid_promo_group_id']] = 'grid_promos';
        }

        $group_config = [
            'grid_promos' => 'limit:' . $limit,
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
