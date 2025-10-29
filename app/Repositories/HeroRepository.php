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
        $hero = [];

        /* 
         * Transform global hero into a component
         */
        if (!empty($promos['hero'])) {
            $hero = [
                'data' => $promos['hero'],
                'component' => [
                    'heroPlacement' => config('base.hero_placement'),
                    'heroType' => '',
                ],
            ];
        }

        /* 
         * Hero component overrides global hero
         */
        if (!empty($promos['components'])) {
            $hero_components = collect($promos['components'])->reject(function ($data, $component_name) {
                return !str_contains($component_name, 'hero');
            })->toArray();

            if (!empty($hero_components)) {
                $hero_key = array_key_first($hero_components);
            }

            if (!empty($promos['components'][$hero_key]['data'])) {
                $hero['data'] = $promos['components'][$hero_key]['data'];
                $hero['component']['heroPlacement'] = $promos['hero']['component']['heroPlacement'] ?? config('base.hero_placement');
            }
        }

        /*
         * Set hero from component
         * Determine hero placement and hero type from option 
         *
         * NOTE:
         * Overriding the selected option from the component config 
         * happens within ModularPageRepository->adjustPromoData();
         */

        /*
         * Hero type
         * Defines how and what data will display
         */
        $large = ['large', 'banner'];
        $slim = ['slim', 'small'];
        $split = ['split', 'half'];
        $overlay = ['overlay', 'buttons'];
        $hero_types = array_merge($large, $slim, $split, $overlay);

        if (!empty($hero) && !empty($hero['data'])) {
            foreach ($hero['data'] as $hero_key => $hero_data) {

                // Explode options to compare strings
                $hero_options[$hero_key] = explode(' ',strtolower($hero_data['option']));
                dump( '--- Hero options ---', $hero_options);

                /*
                 * Hero type
                 * Defines how and what data will display
                 */

                if (!empty(array_intersect($hero_options[$hero_key], $hero_types))) {
                    if (Str::contains($hero_data['option'], $slim)) {
                        $hero['component']['heroType'] = 'slim';
                    } elseif (Str::contains($hero_data['option'], $split)) {
                        $hero['component']['heroType'] = 'split';
                    } elseif (Str::contains($hero_data['option'], $overlay)) {
                        $hero['component']['heroType'] = 'overlay';
                    } else {
                        $hero['component']['heroType'] = 'large';
                    }
                }
            }

            if (count($hero['data']) != 1) {
                $hero['component']['heroType'] = 'carousel';
            } else {
                $hero_data = current($hero['data']);
                $hero_data['option'] = strtolower($hero_data['option']);

                if (!empty($hero_data['option'])) {

                    /*
                     * Hero placement
                     * Defines where the hero will display within the template 
                     */
                    $hero_placement = [
                        'full-width',   // full-width
                        'banner',       // full-width
                        'contained',    // content area
                    ];

                    if (!empty(array_intersect($hero_options, $hero_placement))) {
                        if (Str::contains($hero_data['option'], 'banner')) {
                            $hero['component']['heroPlacement'] = 'full-width';
                        } elseif (Str::contains($hero_data['option'], 'contained')) {
                            $hero['component']['heroPlacement'] = 'contained';
                        } else {
                            $hero['component']['heroPlacement'] = config('base.hero_placement');
                        }
                    }
                }
            }
        }

        dump(
            '--- Placement and Style Results ---', 
            $hero['component']
        );

        // Add hero back into promos
        unset($promos['hero']);
        $promos['hero'] = $hero;

        return $promos;
    }
}

//global
            /*
            // Set heroType from option
            foreach ($promos['hero']['data'] as $hero_type) {
                if (count($promos['hero']['data']) === 1) {
                    $promos['hero']['component']['heroType'] = !empty($hero_type['option']) ? Str::slug(strtolower($hero_type['option'])) : 'banner';
                } else {
                    $promos['hero']['component']['heroType'] = 'carousel';
                }
            }
             */

// root
        /*
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
         */

        // Hero items
        // Set standard heroStyle and heroSize
        /*
        if (!empty($hero['data'])) {
            $hero['data'] = collect($hero['data'])->map(function ($hero_data) {
                // Replace Hero Buttons option with Text Overlay
                if (!empty($hero_data['option']) && $hero_data['option'] == 'Buttons') {
                    $hero_data['option'] = 'Text Overlay';
                }

                // Support old options
                if (!empty($hero_data['option'])) {
                    // Remove word 'banner' to set the size
                    $hero_data['heroSize'] = trim(str_ireplace('banner', '', $hero_data['option']));
                    //full width, half,     

                    // Keep 'banner' for style
                    $hero_data['option'] = trim(str_ireplace(['small','large','contained'], '', $hero_data['option']));
                }

                return $hero_data;
            })->toArray();
        }
         */
