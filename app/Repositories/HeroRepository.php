<?php

namespace App\Repositories;

use Contracts\Repositories\RequestDataRepositoryContract;
use Contracts\Repositories\PromoRepositoryContract;
use Contracts\Repositories\HeroRepositoryContract;
use Contracts\Repositories\ModularPageRepositoryContract;
use Illuminate\Cache\Repository;
use Waynestate\Api\Connector;
use Waynestate\Promotions\ParsePromos;

class HeroRepository implements HeroRepositoryContract
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
    public function __construct(
        Connector $wsuApi,
        ParsePromos $parsePromos,
        Repository $cache,
        ModularPageRepositoryContract $components
    ) {
        $this->wsuApi = $wsuApi;
        $this->parsePromos = $parsePromos;
        $this->cache = $cache;
        $this->components = $components;
    }

    /**
     * {@inheritdoc}
     */
    public function setHero(array $promos, array $groups, array $data)
    {
        // Force global promos into the component structure
        if (!empty($promos['hero'])) {
            // Preserve the hero data
            $temporary_hero = $promos['hero'];
            unset($promos['hero']);

            // Force hero data into component structure
            if (empty($promos['hero']['data'])) {
                $promos['hero']['data'] = $temporary_hero;
            }

            if (empty($promos['hero']['component'])) {
                $promos['hero']['component'] = [];
            }

            foreach ($promos['hero']['data'] as $hero) {
                // Force the correct component option based on the layout
                if (count($promos['hero']['data']) === 1) {
                    if (isset($hero['option']) && $hero['option'] === 'Banner contained') {
                        $promos['hero']['component']['option'] = 'Banner contained';
                    } elseif (!isset($hero['option']) && config('base.layout') == 'contained-hero') {
                        $promos['hero']['component']['option'] = 'Banner contained';
                    } elseif (!isset($hero['option'])) {
                        $promos['hero']['component']['option'] = 'Banner small';
                    }
                }
            }
        }

        // Override hero from components
        $hero = collect($promos['components'])->reject(function ($data, $component_name) {
            return !str_contains($component_name, 'hero');
        })->toArray();

        if (!empty($hero)) {
            $hero_key = array_key_first($hero);
            if(!empty($promos['components'][$hero_key]['data'])) {
                $promos['hero'] = $promos['components'][$hero_key];
                config(['base.hero_full_controllers' => [$data['page']['controller']]]);
                unset($promos['components'][$hero_key]);
            }
        }

        return $promos;
    }
}
