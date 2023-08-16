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

        // Import ability to use json config
        // determine page field name 'modular_buttons'
        // learn css container queries
        // take left menu or no menu into account
        // set up styleguide to use live repository like the promo page

        if (!empty($data['data'])) {
            foreach ($data['data'] as $group_title => $group_info) {
                // Only use fields with modular in the name
                if (str_contains($group_title, 'modular')) {
                    // Modify field name to match component filename
                    $group_title = str_replace('modular_', '', $group_title);
                    $group_title = str_replace('_', '-', $group_title);
                    /*
                     * consider multiple text blocks
                    $position = strpos($group_title, '-');
                    if ($position !== false) {
                        $group_title = substr($group_title, 0, $position);
                    }
                     */

                    // Create array of the groups that are not flattened by 'first'
                    // Use later to reset keys to use group title
                    // $promo_group_title[0]['group']['title']
                    if (!str_contains($group_info, 'first')) {
                        $array_values[] = $group_title;
                    }

                    // Separate the promo id and config
                    $group_info = explode(",", $group_info);
                    $group_id = $group_info[0];

                    // Set page id
                    if (!empty($group_info[1])) {
                        if (str_contains($group_info[1], 'page_id')) {
                            $group_info[1] = preg_replace('/\bpage_id\b/', 'page_id:'.$data['page']['id'], $group_info[1]);
                        }

                        $group_info = trim($group_info[1]);
                    } else {
                        $group_info = '';
                    }

                    $group_reference[$group_id] = $group_title;
                    $group_config[$group_title] = $group_info;
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

        $promos = $this->parsePromos->parse($promos, $group_reference, $group_config);

        if (!empty($promos)) {
            // Reset keys to set group title
            // $promo_group_title[0]['group']['title']
            foreach ($promos as $group_title => $values) {
                if (in_array($group_title, $array_values)) {
                    $promos[$group_title] = array_values($promos[$group_title]);
                }
            }
        }

        return $promos;
    }
}
