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
        
        if (!empty($data['data']['listing_promo_group_id'])) {
            $group_reference[$data['data']['listing_promo_group_id']] = 'promos';
        } elseif (!empty($data['data']['grid_promo_group_id'])) {
            $group_reference[$data['data']['grid_promo_group_id']] = 'promos';
        } else {
            return ['promos' => []];
        }

        $group_config = ['promos' => 'limit:' . $limit];

        $params = [
            'method' => 'cms.promotions.listing',
            'promo_group_id' => array_keys($group_reference),
            'filename_url' => true,
            'is_active' => '1',
        ];

        $promos = $this->cache->remember($params['method'].md5(serialize($params)), config('cache.ttl'), function () use ($params) {
            return $this->wsuApi->sendRequest($params['method'], $params);
        });

        $promos = $this->parsePromos->parse($promos, $group_reference, $group_config);

        if (!empty($data['data']['promotion_view_boolean']) && $data['data']['promotion_view_boolean'] === 'true') {
            $promos['promos'] = collect($promos['promos'])->map(function ($item) use ($data) {
                $item['link'] = 'view/'.\Illuminate\Support\Str::slug($item['title']).'-'.$item['promo_item_id'];

                return $item;
            })->toArray();
        }

        return $promos;
    }

    /**
     * {@inheritdoc}
     */
    public function getPromoView($id)
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

        $promo['promo'] = empty($promo['error']) ? $promo['promo'] : [];

        return $promo;
    }

    /**
     * {@inheritdoc}
     */
    public function getBackToPromoListing($referer = null, $scheme = null, $host = null, $uri = null)
    {
        // Make sure the referer is coming from the site we are currently on and not the current page
        if ($referer === null
            || $referer == $scheme.'://'.$host.$uri
            || strpos($referer, $host) === false
        ) {
            return '';
        }

        return $referer;
    }
}
