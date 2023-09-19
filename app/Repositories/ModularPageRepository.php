<?php

namespace App\Repositories;

use Contracts\Repositories\ModularPageRepositoryContract;
use Contracts\Repositories\PromoPageRepositoryContract;
use Illuminate\Cache\Repository;
use Waynestate\Api\Connector;
use Waynestate\Promotions\ParsePromos;

class ModularPageRepository extends PromoPageRepository implements ModularPageRepositoryContract
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
    public function getModularPromos(array $data)
    {
        $group_reference = [];
        $group_config = [];

        // learn css container queries
        // take left menu or no menu into account
        // set up configurable events and news ids if set

        if (!empty($data['data'])) {
            foreach ($data['data'] as $component => $properties) {
                // Only use fields with modular in the name
                if (str_contains($component, 'modular')) {
                    // Modify field name to match component filename
                    $component = str_replace('modular-', '', $component);
                    $component = str_replace('_', '-', $component);

                    if (str_starts_with($properties, '{') === true) {
                        $components[$component] = $this->parsePromoJSON($properties, $data['page']['id']);
                    }

                    // Parse promos
                    $group_reference[$components[$component]['id']] = $component;
                    $group_config[$component] = $components[$component]['config'];
                }
            }
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

        // Append component page field data to each promo item 
        foreach($components as $component => $component_props) {
            foreach($promos['promotions'] as $key => $item) {
                if($component_props['id'] === (int)$item['group']['promo_group_id']) {
                    foreach($component_props as $prop_name => $prop_data) {
                        $promos['promotions'][$item['promo_item_id']]['component'][$prop_name] = $prop_data;
                    }
                }
            }
        }

        $promos = $this->parsePromos->parse($promos, $group_reference, $group_config);

        // Reset promo item key to use component values in template 
        if (!empty($promos)) {
            foreach ($promos as $component => $values) {
                $promos[$component] = array_values($promos[$component]);
            }
        }
        dump($promos);
        dump($components);

        return $promos;
    }
}
