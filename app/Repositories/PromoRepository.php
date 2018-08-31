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

        return $this->parsePromos->parse($promos, $group_reference, $group_config);
    }

    /**
     * {@inheritdoc}
     */
    public function getRequestData(array $data)
    {
        // Get the global promos config
        $config = config('base.global_promos');

        // Set the key for the global promos array
        $key = $data['site']['parent']['id'] === null ? 'main' : $data['site']['id'];

        // Figure out which set of groups to use
        $groups = !empty($config['subsites'][$key]) ? $config['subsites'][$key] : $config['main'];

        // Setup the group reference array for this site
        $group_reference = collect($groups)->reject(function ($group) {
            return empty($group['id']);
        })->mapWithKeys(function ($group, $name) {
            $group_reference[$group['id']] = $name;

            return [$group['id'] => $name];
        })->toArray();

        // Always get the main site's social and contact incase we need them on the subsite
        if (!empty($config['main']['social']['id'])) {
            $group_reference[$config['main']['social']['id']] = 'main_social';
        }
        if (!empty($config['main']['contact']['id'])) {
            $group_reference[$config['main']['contact']['id']] = 'main_contact';
        }

        // If there is an accordion custom page field then inject it into the group reference
        if (!empty($data['data']['accordion_promo_group_id']) && ! array_key_exists($data['data']['accordion_promo_group_id'], $group_reference)) {
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

        // Setup the group reference array for this site
        $group_config = collect($groups)->mapWithKeys(function ($group, $name) use ($config, $data) {
            // If the subsite has a config value use that otherwise try to use the main config
            if (!empty($group['config'])) {
                $value = $group['config'];
            } elseif (!empty($config['main'][$name]['config'])) {
                $value = $config['main'][$name]['config'];
            } else {
                $value = null;
            }

            return [$name => str_replace('{$page_id}', $data['page']['id'], $value)];
        })->reject(function ($value) {
            return empty($value);
        })->toArray();

        // Set the main social config
        if (!empty($config['main']['social']['config'])) {
            $group_config['main_social'] = $config['main']['social']['config'];
        }

        // Set the main contact config
        if (!empty($config['main']['contact']['config'])) {
            $group_config['main_contact'] = $config['main']['contact']['config'];
        }

        // If rotating hero images are allowed on this controller then change the limit
        if (in_array($data['page']['controller'], config('base.hero_rotating_controllers'))) {
            $group_config = str_replace('|limit:1', '|limit:'.config('base.hero_rotating_limit'), $group_config);
        }

        // Add to full hero controllers list if the page has no site menu or its not being shown
        if ((!empty($data['site_menu']) && empty($data['site_menu']['menu'])) || (!empty($data['site_menu']['menu']) && $data['show_site_menu'] === false)) {
            $controllers = config('base.hero_full_controllers');
            array_push($controllers, $data['page']['controller']);
            config(['base.hero_full_controllers' => $controllers]);
        }

        // Parsed promotions
        $promos = $this->parsePromos->parse($promos, $group_reference, $group_config);

        // Override the site's social icons if it doesn't have any
        if (empty($promos['social']) && !empty($promos['main_social'])) {
            $promos['social'] = $promos['main_social'];
        }

        // Inject the main contact footer if we are on a subsite
        if (!empty($promos['contact']) && (empty($groups['contact']['override']) || $groups['contact']['override'] === false)) {
            $promos['contact'] = array_merge($promos['contact'], $promos['main_contact']);
        } elseif (empty($promos['contact']) && !empty($promos['main_contact'])) {
            $promos['contact'] = $promos['main_contact'];
        }

        // Remove the uncessary promo groups
        unset($promos['main_social']);
        unset($promos['main_contact']);


        dump($promos);
        return $promos;
    }
}
