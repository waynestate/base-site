<?php

namespace App\Repositories;

use Contracts\Repositories\HeroRepositoryContract;
use Illuminate\Cache\Repository;
use Waynestate\Api\Connector;
use Illuminate\Support\Str;

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
        // Transform global promos into the component structure
        if (!empty($promos['hero'])) {
            // Preserve hero data and remove from promos
            $temporary_hero = $promos['hero'];
            unset($promos['hero']);

            // Give hero data component structure
            if (empty($promos['hero']['data'])) {
                $promos['hero']['data'] = $temporary_hero;
            }

            // Create component data and set default heroSize
            if (empty($promos['hero']['component'])) {
                $promos['hero']['component'] = [];
                $promos['hero']['component']['heroSize'] = config('base.hero_size');
            }

            // Set heroStyle from option
            foreach ($promos['hero']['data'] as $hero) {
                if (count($promos['hero']['data']) === 1) {
                    $promos['hero']['component']['heroStyle'] = !empty($hero['option']) ? Str::slug($hero['option']) : 'banner';
                } else {
                    $promos['hero']['component']['heroStyle'] = 'carousel';
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
                $promos['hero']['component']['heroSize'] = $promos['hero']['component']['heroSize'] ?? config('base.hero_size');
                unset($promos['components'][$hero_key]);
            }
        }

        // Set standard heroStyle and heroSize
        if (!empty($promos['hero'])) {
            $promos['hero']['data'] = collect($promos['hero']['data'])->map(function ($hero_data) {
                // Replace Hero Buttons option with Text Overlay
                if (!empty($hero_data['option']) && $hero_data['option'] == 'Buttons') {
                    $hero_data['option'] = 'Text Overlay';
                }

                // Support old options
                if (!empty($hero_data['option'])) {
                    // Remove word 'banner' to set the size
                    $hero_data['heroSize'] = trim(str_ireplace('banner', '', $hero_data['option']));

                    // Keep 'banner' for style
                    $hero_data['option'] = trim(str_ireplace(['small','large','contained'], '', $hero_data['option']));
                }

                return $hero_data;
            })->toArray();
        }
        dump($promos);

        return $promos;
    }
}
