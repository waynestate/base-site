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

        // Structure global hero as a component
        if (!empty($promos['hero'])) {
            $hero = [
                'data' => $promos['hero'],
                'component' => [
                    'heroPlacement' => config('base.hero_placement'),
                    'heroType' => config('base.hero_type'),
                ],
            ];
        }


        // Set hero buttons from components
        if (!empty($promos['components'])) {
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
        }

        // Override global hero with hero component
        if (!empty($promos['components'])) {
            // Reject component names that do not contain 'hero'
            $hero_components = collect($promos['components'])->reject(function ($data, $component_name) {
                return !str_contains($component_name, 'hero');
            })->toArray();

            // Take only the first hero component found
            if (!empty($hero_components)) {
                $hero_key = array_key_first($hero_components);
            }

            // Set default hero placemenet
            if (!empty($promos['components'][$hero_key]['data'])) {
                $hero['data'] = $promos['components'][$hero_key]['data'];
                $hero['component'] = $promos['components'][$hero_key]['component'];
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
        $overlay = ['overlay', 'buttons', 'logo', 'svg'];
        $hero_types = array_merge($large, $slim, $split, $overlay);

        /*
         * Hero placement
         * Defines where the hero will display within the template 
         */
        $full_width = ['full-width', 'banner large'];
        $contained = ['contained'];
        $hero_placement = array_merge($full_width, $contained);

        if (!empty($hero) && !empty($hero['data'])) {
            foreach ($hero['data'] as $hero_key => $hero_data) {

                // Explode options to determine type and placement to support previous settings
                $hero['data'][$hero_key]['hero_classes'] = explode(' ',strtolower($hero_data['option'])); 

                // hero container class

                // Determine hero type
                if (!empty(array_intersect($hero['data'][$hero_key]['hero_classes'], $hero_types))) {
                    if (array_intersect($hero['data'][$hero_key]['hero_classes'], $slim)) {
                        $hero['component']['heroType'] = 'slim';
                        $hero['data'][$hero_key]['hero_classes'][] = 'slim';
                    } elseif (array_intersect($hero['data'][$hero_key]['hero_classes'], $split)) {
                        $hero['component']['heroType'] = 'split';
                        $hero['data'][$hero_key]['hero_classes'][] = 'split';
                    } elseif (array_intersect($hero['data'][$hero_key]['hero_classes'], $overlay)) {
                        $hero['component']['heroType'] = 'overlay';
                        $hero['data'][$hero_key]['hero_classes'][] = 'overlay';
                    } elseif (array_intersect($hero['data'][$hero_key]['hero_classes'], $large)) {
                        $hero['component']['heroType'] = 'large';
                        $hero['data'][$hero_key]['hero_classes'][] = 'large';
                    }
                } else {
                    if (!empty($hero['component']['heroType']) && strtolower($hero['component']['heroType']) === 'carousel') {
                        $hero['data'][$hero_key]['hero_type'] = 'large';
                    } else {
                        // Set the default hero type when hero is set only from component
                        $hero['component']['heroType'] = $hero['component']['heroType'] ?? config('base.hero_type');
                        $hero['data'][$hero_key]['hero_type'] = $hero['component']['heroType'] ?? config('base.hero_type');
                    }
                }

                // Determine hero placement
                if (count($hero['data']) != 1) {
                    $hero['component']['heroType'] = 'carousel';
                } else {
                    if (!empty(array_intersect($hero['data'][$hero_key]['hero_classes'], $hero_placement))) {
                        if (array_intersect($hero['data'][$hero_key]['hero_classes'], $full_width)) {
                            $hero['component']['heroPlacement'] = 'full-width';
                        } elseif (array_intersect($hero['data'][$hero_key]['hero_classes'], $contained)) {
                            $hero['component']['heroPlacement'] = 'contained';
                        } else {
                            $hero['component']['heroPlacement'] = $hero['component']['heroPlacement'] ?? config('base.hero_placement');
                        }
                    } else {
                        if (!empty($hero['data'][$hero_key]['option']) && in_array(strtolower($hero['data'][$hero_key]['option']), $full_width)) {
                            // Override placement for 'banner large' option
                            $hero['component']['heroPlacement'] = 'full-width';
                        }
                    }
                }
            }

            // Override heroPlacement with component config
            $hero['component']['heroPlacement'] = $hero['component']['heroPlacement'] ?? config('base.hero_placement');
        }

        //dump($hero['component']);

        // Add hero back into promos
        unset($promos['hero']);
        $promos['hero'] = $hero;

        return $promos;
    }
}
