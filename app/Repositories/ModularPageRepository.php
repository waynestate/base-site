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
                    $group_title = str_replace('modular-', '', $group_title);
                    $group_title = str_replace('_', '-', $group_title);


                    if (str_starts_with($group_info, '{') === true) {
                        $group_info = $this->parsePromoJSON($group_info);
                    }

                    // Create array of the groups that are not flattened by 'first'
                    // Use later to reset keys to use group title
                    // $promo_group_title[0]['group']['title']
                    if (!str_contains($group_info['config'], 'first')) {
                        $array_values[] = $group_title;
                    }

                    // Parse promos
                    $group_reference[$group_info['id']] = $group_title;
                    $group_config[$group_title] = $group_info['config'];
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

        // Reset keys to set group title
        // $promo_group_title[0]['group']['title']
        if (!empty($promos)) {
            foreach ($promos as $group_title => $values) {
                if (in_array($group_title, $array_values)) {
                    $promos[$group_title] = array_values($promos[$group_title]);
                }
            }
        }

        dump($promos);
        return $promos;
    }
}
