<?php

namespace App\Repositories;

use Contracts\Repositories\ModularPageRepositoryContract;
use Illuminate\Cache\Repository;
use Waynestate\Api\Connector;
use Waynestate\Promotions\ParsePromos;

class ModularPageRepository implements ModularPageRepositoryContract
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
                    } else {
                        // If only an ID is entered without json
                        $components[$component]['id'] = (int)$properties;
                        $components[$component]['config'] = '';
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

        $promos = $this->appendComponentProperties($promos, $components);

        $promos = $this->parsePromos->parse($promos, $group_reference, $group_config);

        // Reset promo item key to use component values in template 
        if (!empty($promos)) {
            foreach ($promos as $component => $values) {
                $promos[$component] = array_values($promos[$component]);
            }
        }

        return $promos;
    }

    /**
     * {@inheritdoc}
     */
    public function parsePromoJSON($json, $page_id)
    {
        $component = [];

        // Remove all spaces and line breaks
        $component = preg_replace('/\s*\R\s*/', '', $json);

        // Last item cannot have comma at the end of it
        $component = preg_replace('(,})', '}', $component);

        // JSON to array
        $component = json_decode($component, true);

        // Make sure config always exists
        $component['config'] = (!empty($component['config']) ? $component['config'] : '');

        // Append actual page id to config
        if (str_contains($component['config'], 'page_id')) {
            $component['config'] = preg_replace('/\bpage_id\b/', 'page_id:'.$page_id, $component['config']);
        }

        // Not allowing "first" config option
        // API seems to do fine with double pipes, so not handling them at this time
        if (str_contains($component['config'], 'first')) {
            $component['config'] = preg_replace('/\bfirst\b/', '', $component['config']);
        }

        return $component;
    }
    
    /**
     * {@inheritdoc}
     */
    public function appendComponentProperties($promos, $components = null)
    {
        // Append component page field data and filename to each promo item
        if(!empty($components)) {
            foreach($components as $component => $component_props) {
                foreach($promos['promotions'] as $key => $item) {
                    if($component_props['id'] === (int)$item['group']['promo_group_id']) {
                        foreach($component_props as $prop_name => $prop_data) {
                            $promos['promotions'][$item['promo_item_id']]['component'][$prop_name] = $prop_data;
                            $promos['promotions'][$item['promo_item_id']]['component']['filename'] = preg_replace('/-\d+$/', '', $component);
                        }
                    }
                }
            }
        }

        return $promos;
    }
}
