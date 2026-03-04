<?php

namespace App\Repositories;

use Contracts\Repositories\HeroRepositoryContract;
use Illuminate\Cache\Repository;
use Waynestate\Api\Connector;
use Illuminate\Support\Facades\Storage;

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

        if (empty($hero) || empty($hero['data'])) {
            return $promos;
        }

        $heroCount = count($hero['data']);
        $heroLimit = (int) ($hero['component']['limit'] ?? 1);
        $isCarousel = $heroCount > 1 || $heroLimit > 1;

        foreach ($hero['data'] as $hero_key => $hero_data) {
            $promoOption = strtolower($hero_data['option'] ?? '');
            $componentOption = strtolower($hero['component']['option'] ?? '');
            $option = trim($promoOption . ' ' . $componentOption);
            $hero_data['hero_options'] = explode(' ', $option);

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

                $hero_data['hero_classes'] = '';
            } else {
                // Determine Type
                $type = $this->mapType($promoOption, $componentOption);
                if ($type) {
                    $hero['component']['heroType'] = $type;
                    $hero_data['hero_classes'] = 'hero--' . $type;
                } else {
                    $type = $hero['component']['heroType'] ?? config('base.hero_type') ?? 'large';
                    $hero['component']['heroType'] = $type;
                    $hero_data['hero_classes'] = $type === 'large' ? '' : 'hero--' . $type;
                }

                // Determine Placement
                $placement = $this->mapPlacement($promoOption, $componentOption);
                if ($placement) {
                    $hero['component']['heroPlacement'] = $placement;
                }
            }

            // Secondary image processing
            if (!empty($hero_data['secondary_relative_url'])) {
                $hero_data = $this->processSecondaryImage($hero_data);
            }

            $hero['data'][$hero_key] = $hero_data;
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
            'slim' => ['slim', 'small'],
            'split' => ['split', 'half'],
            'text' => ['text'],
            'buttons' => ['buttons'],
            'logo' => ['logo'],
            'svg' => ['svg'],
            'carousel' => ['carousel'],
            'large' => ['large', 'banner'],
        ];

        // Check component first for override
        if (!empty($componentOption)) {
            foreach ($typeMap as $type => $keywords) {
                foreach ($keywords as $keyword) {
                    if (preg_match('/\b' . preg_quote($keyword, '/') . '\b/', $componentOption)) {
                        return $type;
                    }
                }
            }
        }

        // Check promo if not found in component
        if (!empty($promoOption)) {
            foreach ($typeMap as $type => $keywords) {
                foreach ($keywords as $keyword) {
                    if (preg_match('/\b' . preg_quote($keyword, '/') . '\b/', $promoOption)) {
                        return $type;
                    }
                }
            }
        }

        return null;
    }

    /**
     * Map keywords to hero placements.
     */
    private function mapPlacement(string $promoOption, string $componentOption): ?string
    {
        $placementMap = [
            'contained' => ['contained'],
            'full-width' => ['full-width', 'full', 'banner', 'large', 'banner large'],
        ];

        // Check component first for override
        if (!empty($componentOption)) {
            foreach ($placementMap as $placement => $keywords) {
                foreach ($keywords as $keyword) {
                    if (preg_match('/\b' . preg_quote($keyword, '/') . '\b/', $componentOption)) {
                        return $placement;
                    }
                }
            }
        }

        // Check promo if not found in component
        if (!empty($promoOption)) {
            foreach ($placementMap as $placement => $keywords) {
                foreach ($keywords as $keyword) {
                    if (preg_match('/\b' . preg_quote($keyword, '/') . '\b/', $promoOption)) {
                        return $placement;
                    }
                }
            }
        }

        return null;
    }

    /**
     * Process secondary image extension and base64 encoding.
     */
    private function processSecondaryImage(array $hero_data): array
    {
        $secondary_url = $hero_data['secondary_relative_url'];
        $secondary_path = parse_url($secondary_url, PHP_URL_PATH);
        $hero_data['secondary_extension'] = pathinfo($secondary_path, PATHINFO_EXTENSION);

        // If it's an SVG and not already base64 encoded
        if ($hero_data['secondary_extension'] === 'svg' && ! str_contains($secondary_url, 'base64')) {
            $clean_path = ltrim($secondary_path, '/');
            $content = null;

            if (Storage::disk('public')->exists($clean_path)) {
                $content = Storage::disk('public')->get($clean_path);
            } elseif (Storage::disk('base')->exists($clean_path)) {
                $content = Storage::disk('base')->get($clean_path);
            } elseif (Storage::disk('base')->exists('public/' . $clean_path)) {
                $content = Storage::disk('base')->get('public/' . $clean_path);
            }

            if ($content) {
                $hero_data['secondary_relative_url'] = 'data:image/svg+xml;base64,'.base64_encode($content);
            }
        }

        return $hero_data;
    }
}
