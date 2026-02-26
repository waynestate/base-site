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
            $hero_buttons = collect($promos['components'])->filter(function ($data, $component_name) {
                return str_contains($component_name, 'hero-buttons');
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
            $hero_components = collect($promos['components'])->filter(function ($data, $component_name) {
                return str_contains($component_name, 'hero');
            })->toArray();

            if (!empty($hero_components)) {
                $hero_key = array_key_first($hero_components);

                if (!empty($promos['components'][$hero_key]['data'])) {
                    $hero['data'] = $promos['components'][$hero_key]['data'];
                    $hero['component'] = $promos['components'][$hero_key]['component'] ?? [];

                    // Extract option from config string if it exists
                    if (!empty($hero['component']['config']) && empty($hero['component']['option'])) {
                        $config = explode('|', $hero['component']['config']);
                        foreach ($config as $config_item) {
                            if (str_contains($config_item, 'option:')) {
                                $hero['component']['option'] = str_replace('option:', '', $config_item);
                                break;
                            }
                        }
                    }

                    $hero['component']['heroPlacement'] = $hero['component']['heroPlacement'] ?? config('base.hero_placement');
                    $hero['component']['heroType'] = $hero['component']['heroType'] ?? config('base.hero_type');

                    unset($promos['components'][$hero_key]);
                }
            }
        }

        if (empty($hero) || empty($hero['data'])) {
            return $promos;
        }

        // Define Mappings
        $typeMap = [
            'slim' => ['slim', 'small'],
            'split' => ['split', 'half'],
            'text' => ['text'],
            'buttons' => ['buttons'],
            'logo' => ['logo'],
            'svg' => ['svg'],
            'large' => ['large', 'banner'],
        ];

        $placementMap = [
            'full-width' => ['full-width', 'banner large'],
            'contained' => ['contained'],
        ];

        $isCarousel = count($hero['data']) > 1;

        foreach ($hero['data'] as $hero_key => $hero_data) {
            $promoOption = strtolower($hero_data['option'] ?? '');
            $componentOption = strtolower($hero['component']['option'] ?? '');
            $option = trim($promoOption . ' ' . $componentOption);
            $hero['data'][$hero_key]['hero_options'] = explode(' ', $option);

            if ($isCarousel) {
                $hero['component']['heroType'] = 'carousel';
                $hero['component']['heroPlacement'] = 'full-width';
                $hero['data'][$hero_key]['hero_classes'] = 'hero--large';
                continue;
            }

            // Determine Type
            $detectedType = null;
            // Check component first for override
            foreach ($typeMap as $type => $keywords) {
                foreach ($keywords as $keyword) {
                    if (!empty($componentOption) && str_contains($componentOption, $keyword)) {
                        $detectedType = $type;
                        break 2;
                    }
                }
            }
            // Check promo if not found in component
            if ($detectedType === null) {
                foreach ($typeMap as $type => $keywords) {
                    foreach ($keywords as $keyword) {
                        if (str_contains($promoOption, $keyword)) {
                            $detectedType = $type;
                            break 2;
                        }
                    }
                }
            }

            if ($detectedType) {
                $hero['component']['heroType'] = $detectedType;
                $hero['data'][$hero_key]['hero_classes'] = 'hero--' . $detectedType;
            } else {
                $type = $hero['component']['heroType'] ?? config('base.hero_type', 'large');
                $hero['component']['heroType'] = $type;
                $hero['data'][$hero_key]['hero_classes'] = 'hero--' . $type;
            }

            // Determine Placement
            $detectedPlacement = null;
            // Check component first for override
            foreach ($placementMap as $placement => $keywords) {
                foreach ($keywords as $keyword) {
                    if (!empty($componentOption) && str_contains($componentOption, $keyword)) {
                        $detectedPlacement = $placement;
                        break 2;
                    }
                }
            }
            // Check promo if not found in component
            if ($detectedPlacement === null) {
                foreach ($placementMap as $placement => $keywords) {
                    foreach ($keywords as $keyword) {
                        if (str_contains($promoOption, $keyword)) {
                            $detectedPlacement = $placement;
                            break 2;
                        }
                    }
                }
            }

            if ($detectedPlacement) {
                $hero['component']['heroPlacement'] = $detectedPlacement;
            }
        }

        // Default hero placement if not set
        $hero['component']['heroPlacement'] = $hero['component']['heroPlacement'] ?? config('base.hero_placement');

        // Add hero back into promos
        unset($promos['hero']);
        $promos['hero'] = $hero;

        return $promos;
    }
}
