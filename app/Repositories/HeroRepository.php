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
            $promos = $this->getHeroButtons($promos);
        }

        // Override global hero with hero component
        if (!empty($promos['components'])) {
            $extracted = $this->getHeroComponent($promos['components']);
            if (!empty($extracted)) {
                $hero['data'] = $extracted['data'];
                $hero['component'] = $extracted['component'];
                $promos['components'] = $extracted['components'];

                // Slice data if it exceeds component limit
                if (!empty($hero['component']['limit']) && count($hero['data']) > $hero['component']['limit']) {
                    $hero['data'] = array_slice($hero['data'], 0, $hero['component']['limit']);
                }
            }
        }

        if (empty($hero['data'])) {
            return $promos;
        }

        // Initialize the hero component if not set
        $hero['component'] = $hero['component'] ?? [];
        $hero['component']['heroLayout'] = '';

        // Layout is carousel if the limit is more than 1 and there is more than one hero promo item
        $heroCount = count($hero['data']);
        $heroLimit = (int) ($hero['component']['limit'] ?? 1);

        // If it's a global hero (no component limit set), it should be a carousel if there's more than 1 item
        if (!isset($hero['component']['limit']) && $heroCount > 1) {
            $heroLimit = $heroCount;
        }

        $isCarousel = ($heroCount > 1 && $heroLimit > 1);

        // Check if any promo or component option explicitly sets the carousel
        if (!$isCarousel) {
            foreach ($hero['data'] as $hero_data) {
                $option = strtolower(($hero_data['option'] ?? '') . ' ' . ($hero['component']['option'] ?? ''));
                if (str_contains($option, 'carousel')) {
                    $isCarousel = true;
                    break;
                }
            }
        }

        if ($isCarousel) {
            $hero['component']['heroLayout'] = 'carousel';
        }

        // if banner is selected unset title etc 

        foreach ($hero['data'] as $hero_key => $hero_data) {
            $promoOption = strtolower($hero_data['option'] ?? '');
            $componentOption = strtolower($hero['component']['option'] ?? '');
            $option = trim($promoOption . ' ' . $componentOption);
            $hero_data['hero_options'] = explode(' ', $option);
            $hero_data['hero_classes'] = [];

            // Determine Type
            $type = $this->mapType($promoOption, $componentOption);
            if ($type) {
                $hero['component']['heroType'] = $type;
                $hero_data['hero_classes'][] = 'hero--' . $type;
            } else {
                $type = $hero['component']['heroType'] ?? config('base.hero_type') ?? 'banner';
                $hero['component']['heroType'] = $type;
                $hero_data['hero_classes'][] = 'hero--' . $type;
            }

            // Determine Placement
            $placement = $this->mapPlacement($promoOption, $componentOption);
            if ($placement) {
                $hero['component']['heroPlacement'] = $placement;
            }

            // Determine Height
            $height = $this->mapHeight($promoOption, $componentOption);
            if ($height) {
                $hero['component']['heroHeight'] = $height;
                $hero_data['hero_classes'][] = 'hero--' . $height;
            }

            // If carousel, add the class to the item as well
            if ($isCarousel) {
                $hero_data['hero_classes'][] = 'hero--carousel';
            }

            $hero['data'][$hero_key] = $hero_data;
        }

        // Determine carousel type from option if not already set by count or limit
        if (!$isCarousel && str_contains($option, 'carousel')) {
            $isCarousel = true;
        }

        if ($isCarousel) {
            $hero['component']['heroType'] = 'carousel';
            $hero['component']['heroPlacement'] = 'full-width';

            // Determine Placement for carousel
            $placement = $this->mapPlacement($promoOption, $componentOption);
            if ($placement) {
                $hero['component']['heroPlacement'] = $placement;
            }
        }

        // Default hero placement if not set
        $hero['component']['heroPlacement'] = $hero['component']['heroPlacement'] ?? config('base.hero_placement');

        // Add hero back into promos
        unset($promos['hero']);
        $promos['hero'] = $hero;

        return $promos;
    }

    /**
     * Get hero buttons from components.
     */
    private function getHeroButtons(array $promos): array
    {
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

        return $promos;
    }

    /**
     * Get the first hero component from the components array.
     */
    private function getHeroComponent(array $components): array
    {
        $hero_components = collect($components)->filter(function ($data, $component_name) {
            return str_contains($component_name, 'hero');
        })->toArray();

        if (empty($hero_components)) {
            return [];
        }

        $hero_key = array_key_first($hero_components);

        if (empty($components[$hero_key]['data'])) {
            return [];
        }

        $hero = [
            'data' => $components[$hero_key]['data'],
            'component' => $components[$hero_key]['component'] ?? [],
            'option' => $components[$hero_key]['option'] ?? '',
        ];

        // Extract options and limit from config string if they exist
        if (!empty($hero['component']['config'])) {
            if (empty($hero['option']) && empty($hero['component']['option'])) {
                $hero['component']['option'] = $this->parseComponentOption($hero['component']['config']);
            }
            $hero['component']['limit'] = $this->parseComponentLimit($hero['component']['config']);
        }

        // Favor top-level option if it exists
        if (!empty($hero['option'])) {
            $hero['component']['option'] = $hero['option'];
        }

        $hero['component']['heroPlacement'] = $hero['component']['heroPlacement'] ?? config('base.hero_placement');
        $hero['component']['heroType'] = $hero['component']['heroType'] ?? config('base.hero_type');

        unset($components[$hero_key]);

        return [
            'data' => $hero['data'],
            'component' => $hero['component'],
            'components' => $components,
        ];
    }

    /**
     * Extract option from config string.
     */
    private function parseComponentOption(string $config): string
    {
        $config = explode('|', $config);
        foreach ($config as $config_item) {
            if (str_contains($config_item, 'option:')) {
                return str_replace('option:', '', $config_item);
            }
        }

        return '';
    }

    /**
     * Extract limit from config string.
     */
    private function parseComponentLimit(string $config): int
    {
        $config = explode('|', $config);
        foreach ($config as $config_item) {
            if (str_contains($config_item, 'limit:')) {
                return (int) str_replace('limit:', '', $config_item);
            }
        }

        return 1;
    }

    /**
     * Map keywords to hero types.
     */
    private function mapType(string $promoOption, string $componentOption): ?string
    {
        $typeMap = [
            'banner' => ['slim', 'small'],
            'split' => ['split', 'half'],
            'text' => ['text'],
            'buttons' => ['buttons'],
            'logo' => ['logo'],
            'svg' => ['svg'],
            'carousel' => ['carousel'],
        ];

        $option = $promoOption ?? $componentOption;

        // Component will override promo option
        if (!empty($option)) {
            foreach ($typeMap as $type => $keywords) {
                foreach ($keywords as $keyword) {
                    if (preg_match('/\b' . preg_quote($keyword, '/') . '\b/', $option)) {
                        return $type;
                    }
                }
            }
        }

        $unsetMap = [
            'title' => [],
            'description' => [],
            'excerpt' => [],
            'filename_url' => [],
            'secondary_image' => [],
            'banner' => ['slim', 'small'],
            'split' => ['split', 'half'],
            'text' => ['text'],
            'buttons' => ['buttons'],
            'logo' => ['logo'],
            'svg' => ['svg'],
            'carousel' => ['carousel'],
        ];


        return null;
    }

    /**
     * Map keywords to hero placements.
     */
    private function mapPlacement(string $promoOption, string $componentOption): ?string
    {
        $placementMap = [
            'contained' => ['contained'],
            'full-width' => ['full-width', 'full', 'large',],
        ];

        $option = $promoOption ?? $componentOption;

        // Component will override promo option
        if (!empty($option)) {
            foreach ($placementMap as $type => $keywords) {
                foreach ($keywords as $keyword) {
                    if (preg_match('/\b' . preg_quote($keyword, '/') . '\b/', $option)) {
                        return $type;
                    }
                }
            }
        }

        return null;
    }

    /**
     * Map keywords to hero height.
     */
    private function mapHeight(string $promoOption, string $componentOption): ?string
    {
        $heightMap = [
            'slim' => ['slim', 'small'],
            'large' => ['large'],
        ];

        $option = $promoOption ?? $componentOption;

        // Component will override promo option
        if (!empty($option)) {
            foreach ($heightMap as $height => $keywords) {
                foreach ($keywords as $keyword) {
                    if (preg_match('/\b' . preg_quote($keyword, '/') . '\b/', $option)) {
                        return $height;
                    }
                }
            }
        }

        return null;
    }
}
