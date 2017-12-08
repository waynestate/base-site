<?php

namespace App\Repositories;

use Contracts\Repositories\DataRepositoryContract;
use Contracts\Repositories\PromoRepositoryContract;
use Illuminate\Cache\Repository;
use Waynestate\Api\Connector;
use Waynestate\Promotions\ParsePromos;

class PromoRepository implements DataRepositoryContract, PromoRepositoryContract
{
    /** @var Connector */
    protected $wsuApi;

    /** @var ParsePromos */
    protected $parsePromos;

    /** @var Repository */
    protected $cache;

    /**
     * Construct the PromoRepository.
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
    public function getRequestData(array $data)
    {
        $group_reference = [
            2908 => 'contact',
            2907 => 'social',
            2909 => 'under_menu',
            3001 => 'hero',
            4246 => 'banner',
        ];

        // If there is an accordion custom page field and inject it into the group reference
        if (isset($data['data']['accordion_promo_group_id']) && $data['data']['accordion_promo_group_id'] != ''
            && ! array_key_exists($data['data']['accordion_promo_group_id'], $group_reference)
        ) {
            $group_reference[$data['data']['accordion_promo_group_id']] = 'accordion_page';
        }

        $params = [
            'method' => 'cms.promotions.listing',
            'promo_group_id' => array_keys($group_reference),
            'filename_url' => true,
            'is_active' => '1',
        ];

        $promos = $this->cache->remember($params['method'].md5(serialize($params)), config('cache.ttl'), function () use ($params) {
            return $this->wsuApi->sendRequest($params['method'], $params);
        });

        $group_config = [
            'contact' => 'limit:3',
            'under_menu' => 'page_id:'.$data['page']['id'],
            'hero' => 'page_id:'.$data['page']['id'].'|randomize|limit:1',
            'banner' => 'page_id:'.$data['page']['id'].'|first',
        ];

        if (in_array($data['page']['controller'], config('app.hero_rotating_controllers'))) {
            $group_config = str_replace('|limit:1', '|limit:'.config('app.hero_rotating_limit'), $group_config);
        }

        // Return the parsed promotions
        return $this->parsePromos->parse($promos, $group_reference, $group_config);
    }

    /**
     * {@inheritdoc}
     */
    public function getHomepagePromos()
    {
        $group_reference = [
            123 => 'example',
        ];

        $group_config = [
            'example' => 'first',
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

        // Return the parsed promotions
        return $this->parsePromos->parse($promos, $group_reference, $group_config);
    }
}
