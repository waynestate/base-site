<?php

namespace App\Repositories;

use Contracts\Repositories\HeroRepositoryContract;
use Illuminate\Cache\Repository;
use Waynestate\Api\Connector;

class HeroRepository implements HeroRepositoryContract
{
    /** @var Connector */
    protected $wsuApi;

    /** @var Repository */
    protected $cache;

    /**
     * Construct the repository.
     */
    public function __construct(
        Connector $wsuApi,
        Repository $cache,
    ) {
        $this->wsuApi = $wsuApi;
        $this->cache = $cache;
    }

    /**
     * {@inheritdoc}
     */
    public function setHero(array $promos, array $data)
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

        // Set hero buttons from components
        $hero_buttons = collect($promos['components'])->reject(function ($data, $component_name) {
            return !str_contains($component_name, 'hero-buttons');
        })->toArray();

        if (!empty($hero_buttons)) {
            $hero_buttons_key = array_key_first($hero_buttons);

            if (!empty($promos['components'][$hero_buttons_key])) {
                $promos['hero_buttons'] = $promos['components'][$hero_buttons_key];
                unset($promos['components'][$hero_buttons_key]);
            }
        }

        // Override hero from components
        $hero = collect($promos['components'])->reject(function ($data, $component_name) {
            return !str_contains($component_name, 'hero');
        })->toArray();

        if (!empty($hero)) {
            $hero_key = array_key_first($hero);

            if (!empty($promos['components'][$hero_key]['data'])) {
                $promos['hero'] = $promos['components'][$hero_key];
                config(['base.hero_full_controllers' => [$data['page']['controller']]]);
                unset($promos['components'][$hero_key]);
            }
        }

        // Replace Hero Buttons option with Text Overlay
        // TODO Make hero buttons it's own option
        if (!empty($promos['hero'])) {
            $promos['hero']['data'] = collect($promos['hero']['data'])->map(function ($hero_data) {
                if (!empty($hero_data['option']) && $hero_data['option'] == 'Buttons') {
                    $hero_data['option'] = 'Text Overlay';
                }

                return $hero_data;
            })->toArray();
        }

        return $promos;
    }
}
