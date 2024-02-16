<?php

namespace App\Repositories;

use Contracts\Repositories\RequestDataRepositoryContract;
use Contracts\Repositories\PromoRepositoryContract;
use Illuminate\Cache\Repository;
use Waynestate\Api\Connector;
use Waynestate\Promotions\ParsePromos;

class PromoRepository implements RequestDataRepositoryContract, PromoRepositoryContract
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
    public function getPromoView($id)
    {
        $promo['promotion'] = [];

        $params = [
            'method' => 'cms.promotions.info',
            'promo_item_id' => $id,
            'filename_url' => true,
            'is_active' => '1',
        ];

        $promo = $this->cache->remember($params['method'].md5(serialize($params)), config('cache.ttl'), function () use ($params) {
            return $this->wsuApi->sendRequest($params['method'], $params);
        });

        $promo['promo'] = empty($promo['error']) ? $promo['promotion'] : [];

        return $promo;
    }

    /**
     * {@inheritdoc}
     */
    public function getBackToPromoPage($referer = null, $scheme = null, $host = null, $uri = null)
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

    /**
     * {@inheritdoc}
     */
    public function getRequestData(array $data)
    {

        $group_reference  = $this->createGroupReference($data);
        // Get the global promos config
        $config = config('base.global');

        // Set all the groups
        $groups = $config['all']['promos'];

        // Merge the groups for the site we are on
        if (!empty($config['sites'][$data['site']['id']])) {
            $groups = array_merge($groups, $config['sites'][$data['site']['id']]['promos']);
        }

        // Setup the group reference
        $group_reference = collect($groups)->reject(function ($group) {
            return empty($group['id']);
        })->mapWithKeys(function ($group, $name) {
            $group_reference[$group['id']] = $name;

            return [$group['id'] => $name];
        })->toArray();

        $params = [
            'method' => 'cms.promotions.listing',
            'promo_group_id' => array_keys($group_reference),
            'filename_url' => true,
            'is_active' => '1',
        ];

        $promos = $this->cache->remember($params['method'].md5(serialize($params)), config('cache.ttl'), function () use ($params) {
            return $this->wsuApi->sendRequest($params['method'], $params);
        });

        // Setup the group reference array for this site
        $group_config = collect($groups)->mapWithKeys(function ($group, $name) use ($config, $data) {
            $value = !empty($group['config']) ? $group['config'] : null;

            return [$name => str_replace('{$page_id}', $data['page']['id'], $value)];
        })->reject(function ($value) {
            return empty($value);
        })->toArray();

        // If rotating hero images are allowed on this controller then change the limit
        if (in_array($data['page']['controller'], config('base.hero_rotating_controllers'))) {
            $group_config = str_replace('|limit:1', '|limit:'.config('base.hero_rotating_limit'), $group_config);
        }

        // Parsed promotions
        $promos = $this->parsePromos->parse($promos, $group_reference, $group_config);

        // Override the site's social icons if it doesn't have any
        if (empty($promos['social']) && !empty($promos['main_social'])) {
            $promos['social'] = $promos['main_social'];
        }

        // Inject the main contact footer if we are on a subsite
        $main_contact = $promos['main_contact'] ?? [];
        if (!empty($promos['contact']) && (!isset($groups['contact']['merge_with_main_contact']) || $groups['contact']['merge_with_main_contact'] === true)) {
            $promos['contact'] = array_merge($promos['contact'], $main_contact);
        } elseif (empty($promos['contact']) && !empty($promos['main_contact'])) {
            $promos['contact'] = $main_contact;
        }

        // Inject the main under menu if we are on a subsite
        $main_under_menu = $promos['main_under_menu'] ?? [];
        if (!empty($promos['under_menu']) && (!isset($groups['under_menu']['merge_with_main_under_menu']) || $groups['under_menu']['merge_with_main_under_menu'] === true)) {
            $promos['under_menu'] = array_merge($promos['under_menu'], $main_under_menu);
        } elseif (empty($promos['under_menu']) && !empty($main_under_menu)) {
            $promos['under_menu'] = $main_under_menu;
        }

        // Remove the uncessary promo groups
        unset($promos['main_social']);
        unset($promos['main_contact']);

        return $promos;
    }
}
