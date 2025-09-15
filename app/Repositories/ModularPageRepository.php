<?php

namespace App\Repositories;

use Contracts\Repositories\ModularPageRepositoryContract;
use Contracts\Repositories\EventRepositoryContract;
use Contracts\Repositories\ArticleRepositoryContract;
use Illuminate\Cache\Repository;
use Illuminate\Support\Str;
use Waynestate\Api\Connector;
use Waynestate\Promotions\ParsePromos;

class ModularPageRepository implements ModularPageRepositoryContract
{
    /** @var Connector */
    protected $wsuApi;

    /** @var ParsePromos */
    protected $parsePromos;

    /** @var Repository */
    protected $cache;

    /** @var ArticleRepositoryContract */
    protected $article;

    /** @var EventRepositoryContract */
    protected $event;

    /**
     * Construct the repository.
     *
     * @param Connector $wsuApi
     * @param ParsePromos $parsePromos
     * @param Repository $cache
     * @param ArticleRepositoryContract $article
     * @param EventRepositoryContract $event
     *
     */
    public function __construct(
        Connector $wsuApi,
        ParsePromos $parsePromos,
        Repository $cache,
        ArticleRepositoryContract $article,
        EventRepositoryContract $event
    ) {
        $this->wsuApi = $wsuApi;
        $this->parsePromos = $parsePromos;
        $this->cache = $cache;
        $this->article = $article;
        $this->event = $event;
    }

    /**
     * {@inheritdoc}
     */
    public function getModularComponents(array $data): array
    {
        if (empty($data['data'])) {
            return [];
        }

        $components = [];

        $data = $this->legacyPageFieldSupport($data);

        $rawComponents = $this->parseComponentJSON($data);

        $promos = $this->getPromos($rawComponents, $data['site']['id'] ?? '');

        $components = $this->configureComponents($rawComponents, $promos, $data);

        $components = $this->componentClasses($components);

        $components = $this->componentStyles($components);

        return $components;
    }

    /**
     * {@inheritdoc}
     */
    public function parseComponentJSON(array $data)
    {
        $components = [];
        $group_reference = [];
        $group_config = [];

        foreach ($data['data'] as $pageField => $componentConfig) {

            // Only care about page fields starting with modular
            if (Str::startsWith($pageField, 'modular-')) {

                // Remove modular from component key
                $name = Str::replaceFirst('modular-', '', $pageField);

                // Remove all spaces and line breaks
                $componentConfig = preg_replace('/\s*\R\s*/', '', $componentConfig);

                // Prevent trailing comma
                $componentConfig = preg_replace('(,})', '}', $componentConfig);

                // Interpret component config
                if (Str::startsWith($componentConfig, '{')) {
                    $components[$name] = json_decode($componentConfig, true);

                    // Ensure promo config exists as a string
                    if (empty($components[$name]['config'])) {
                        $components[$name]['config'] = '';
                    }

                    // Modify promo config
                    $promoConfig = explode('|', $components[$name]['config']);

                    foreach ($promoConfig as $key => $value) {
                        // Insert correct page id into config
                        if (Str::startsWith($value, 'page_id')) {
                            $promoConfig[$key] = 'page_id:'.$data['page']['id'];
                        }

                        // Prevent 'first' in the promo config
                        // Return must be an array of promo items
                        if (Str::startsWith($value, 'first')) {
                            unset($promoConfig[$key]);
                        }
                    }

                    // Assume support for youtube links
                    if (strpos($components[$name]['config'], 'youtube') === false) {
                        array_push($promoConfig, 'youtube');
                    }

                    // Return config to correct format for API
                    $components[$name]['config'] = implode('|', $promoConfig);

                    // Identify the component filename, remove dash and number from page field label
                    $components[$name]['filename'] = preg_replace('/-\d+$/', '', $name);
                } else {
                    // Support modular components using a promo_group_id without JSON config
                    $components[$name]['id'] = $componentConfig;
                }

                // Create group_reference and group_config from components with promo data for API call
                if (!Str::contains($name, ['events', 'news']) && !empty($components[$name]['id'])) {
                    $group_reference[$components[$name]['id']] = $name;
                    if (!empty($components[$name]['config'])) {
                        $group_config[$name] = $components[$name]['config'];
                    }
                }
            }
        }

        return [
            'components' => $components,
            'group_reference' => $group_reference,
            'group_config' => $group_config,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getPromos($components, $site_id)
    {
        $params = [
            'method' => 'cms.promotions.listing',
            'promo_group_id' => array_keys($components['group_reference']),
            'filename_url' => true,
            'is_active' => '1',
        ];

        $promos = $this->cache->remember($params['method'] . md5(serialize($params)), config('cache.ttl'), function () use ($params) {
            return $this->wsuApi->sendRequest($params['method'], $params);
        });

        // Use another site's promo items only from Base
        if (!empty($site_id) && $site_id === 1561) {
            $promos['promotions'] = collect($promos['promotions'])->map(function ($promo) {
                if (!empty($promo['filename_url'])) {
                    $promo['relative_url'] = $promo['filename_url'];
                }

                if (!empty($promo['secondary_filename_url'])) {
                    $promo['secondary_relative_url'] = $promo['secondary_filename_url'];
                }

                return $promo;
            })->toArray();
        }

        $promos = $this->parsePromos->parse($promos, $components['group_reference'], $components['group_config']);

        foreach ($promos as $name => $data) {
            // Adjust promo data
            $data = collect($data)->map(function ($item) use ($components, $name) {
                return $this->adjustPromoData($item, $components['components'][$name]);
            })->toArray();

            // Organize by option
            if (!empty($components['components'][$name]['groupByOptions']) && $components['components'][$name]['groupByOptions'] === true && Str::startsWith($name, 'catalog')) {
                $data = $this->organizePromoItemsByOption($data);
            }

            // Build the return
            $promos[$name] = [
                'data' => $data,
                'component' => $components['components'][$name],
            ];
        }

        return $promos;
    }

    /**
     * {@inheritdoc}
     */
    public function configureComponents(array $components, array $promos, array $data): array
    {
        $modularComponents = [];

        foreach ($components['components'] as $name => $component) {
            if (Str::contains($name, 'events') || Str::contains($name, 'news')) {
                if (Str::contains($name, 'events')) {
                    $components['components'][$name]['id'] = $component['events_id'] ?? $component['id'] ?? $data['site']['id'];

                    // Restrict events row to 3 items
                    if (Str::contains($name, 'events-row') && !Str::contains($name, 'featured-events-row')) {
                        $limit = $components['components'][$name]['limit'] ?? 3;
                    } else {
                        $limit = $components['components'][$name]['limit'] ?? 4;
                    }

                    // Use full listing if the name contains featured, or events-row
                    // TODO Find better naming convention
                    if (!Str::contains($name, 'featured') && Str::contains($name, 'column') || Str::contains($name, 'news-and-events')) {
                        $events = $this->event->getEvents($components['components'][$name]['id'] ?? $data['site']['id'], $limit);
                    } else {
                        $events = $this->event->getEventsFullListing($components['components'][$name]['id'] ?? $data['site']['id'], $limit);
                    }

                    // Special data structure for news-and-events component
                    if (Str::contains($name, 'news-and-events')) {
                        $modularComponents[$name]['data']['events'] = $events['events'] ?? [];
                    } else {
                        $modularComponents[$name]['data'] = $events['events'] ?? [];
                    }

                    // Provide a default Events heading
                    if (!array_key_exists('heading', $component)) {
                        $components['components'][$name]['heading'] = 'Events';
                    }

                    // Assign the component data
                    $modularComponents[$name]['component'] = $components['components'][$name];

                    // Set featured events default columns
                    if (Str::contains($name, 'events-featured-row')) {
                        if (empty($components['components'][$name]['columns'])) {
                            $modularComponents[$name]['component']['columns'] = 4;
                        }
                    }

                    // Set the calendar link
                    if (empty($modularComponents[$name]['component']['cal_name']) && !empty($data['site']['events']['path'])) {
                        $modularComponents[$name]['component']['cal_name'] = $data['site']['events']['path'];
                    }
                }
                if (Str::contains($name, 'news')) {
                    $components['components'][$name]['id'] = $component['news_id'] ?? $component['id'] ?? $data['site']['news']['application_id'];
                    $limit = $component['limit'] ?? 4;

                    // Set the news route
                    $components['components'][$name]['news_route'] = $component['news_route'] ?? config('base.news_listing_route');

                    // Use featured news
                    if (!empty($component['featured']) && $component['featured'] === true) {
                        $articles = $this->article->listing($components['components'][$name]['id'], 50, 1, $component['topics'] ?? []);
                        $articles['articles']['data'] = collect($articles['articles']['data'])->filter(function ($article) {
                            return !empty($article['featured']['featured']) && $article['featured']['featured'] === 1;
                        })->take($limit)->toArray();
                    } else {
                        $articles = $this->article->listing($components['components'][$name]['id'], $limit, 1, $component['topics'] ?? []);
                    }

                    // Special data structure for news-and-events component
                    if (Str::contains($name, 'news-and-events')) {
                        $modularComponents[$name]['data']['news'] = $articles['articles']['data'] ?? [];
                    } else {
                        $modularComponents[$name]['data'] = $articles['articles']['data'] ?? [];
                    }

                    // Provide a default News heading
                    if (!array_key_exists('heading', $component)) {
                        $components['components'][$name]['heading'] = 'News';
                    }

                    // Assign the component data
                    $modularComponents[$name]['component'] = $components['components'][$name];
                    $modularComponents[$name]['meta'] = $articles['articles']['meta'] ?? [];

                    if (Str::startsWith($name, 'news-and-events')) {
                        // Clear any set heading
                        // Headings are set in the component blade
                        $modularComponents[$name]['component']['heading'] = '';
                    }
                }
            } elseif (Str::startsWith($name, 'page-content') || Str::startsWith($name, 'heading')) {
                // If there's JSON but no news, events or promo data, assign the component array as data
                // Page-content and heading components
                $modularComponents[$name]['data'][] = $components['components'][$name] ?? [];
                $modularComponents[$name]['component'] = $components['components'][$name] ?? [];
                unset($modularComponents[$name]['component']['heading']);
            } else {
                $modularComponents[$name]['data'] = $promos[$name]['data'] ?? [];
                $modularComponents[$name]['component'] = $promos[$name]['component'] ?? [];
            }
        }

        return $modularComponents;
    }

    public function adjustPromoData($data, $component)
    {
        if (isset($component['singlePromoView']) && $component['singlePromoView'] === true) {
            $data['link'] = 'view/'.Str::slug($data['title']).'-'.$data['promo_item_id'];
        }

        if (isset($component['showExcerpt']) && $component['showExcerpt'] === false) {
            unset($data['excerpt']);
        }

        if (isset($component['showDescription']) && $component['showDescription'] === false) {
            unset($data['description']);
        }

        // Override promo item option with component option
        if (isset($component['option'])) {
            $data['option'] = $component['option'];
        }

        return $data;
    }

    /**
    * {@inheritdoc}
    */
    public function organizePromoItemsByOption(array $data)
    {
        $options_exist = collect($data)->filter(function ($item) {
            return !empty($item['option']);
        })->isNotEmpty();

        if ($options_exist === true) {
            $data = collect($data)->groupBy('option')->toArray();

            if (!empty($data[''])) {
                $no_option_moved_to_bottom = $data[''];
                unset($data['']);
                $data[''] = $no_option_moved_to_bottom;
            }
        }

        return $data;
    }

    public function componentClasses($components)
    {
        foreach ($components as $componentName => $component) {
            // Establishing final arrays so they will always exist
            $components[$componentName]['component']['containerClass'] = $component['component']['containerClass'] ?? [];
            $components[$componentName]['component']['backgroundClass'] = $component['component']['backgroundClass'] ?? [];
            $components[$componentName]['component']['componentClass'] = $component['component']['componentClass'] ?? [];

            // containerClass => filename
            if (!empty($component['component']['filename'])) {
                $components[$componentName]['component']['containerClass'][] = $component['component']['filename'];
            }

            // containerClass => columnSpan
            if (!empty($component['component']['columnSpan'])) {
                // Inject the column span class
                array_push($components[$componentName]['component']['containerClass'], 'px-4', 'mt:colspan-'.$component['component']['columnSpan']);
            } elseif (!empty($component['component']['filename']) && strpos($component['component']['filename'], 'column') !== false) {
                // Inject the column span class
                array_push($components[$componentName]['component']['containerClass'], 'px-4', 'mt:colspan-6');
            } else {
                // Default width
                $components[$componentName]['component']['containerClass'][] = 'px-container';
            }

            // Collect all legacy class names
            $classes = trim(($component['component']['sectionClass'] ?? '').' '.($component['component']['componentClass'] ?? '').' '.($component['component']['classes'] ?? ''));

            // Group the classes based on the container they will be applied to
            // Set backgroundClass, containerClass, componentClass
            if ($classes !== '') {
                $classes = explode(' ', $classes);

                foreach ($classes as $class) {
                    if (strpos($class, 'bg-') !== false) {
                        // backgroundClass
                        $components[$componentName]['component']['backgroundClass'][] = $class;
                    } elseif (strpos($class, 'my-') !== false | strpos($class, 'mt-') !== false | strpos($class, 'mb-') !== false | strpos($class, 'end') !== false | strpos($class, 'left') !== false | strpos($class, 'right') !== false) {
                        // containerClass
                        $components[$componentName]['component']['containerClass'][] = $class;
                    } else {
                        // componentClass
                        $components[$componentName]['component']['componentClass'][] = $class;
                    }
                }
            }

            // Default background image positioning classes, won't overwrite existing backgroundClass values
            if (!empty($component['component']['backgroundImageUrl']) && empty($component['component']['backgroundClass'])) {
                $components[$componentName]['component']['backgroundClass'] = ['bg-cover', 'bg-top'];
            }

            // Section gutters, bottom padding
            // - No gutter if component uses margin-bottom class
            // - No gutter on heading component
            if (empty(preg_grep('/mb-/', $components[$componentName]['component']['containerClass']))
                && !Str::contains($componentName, 'heading')
            ) {
                $components[$componentName]['component']['containerClass'] [] = 'mb-gutter';
            }

            // Implode party, assign all classes to their respective container
            $components[$componentName]['component']['containerClass'] = implode(' ', $components[$componentName]['component']['containerClass']);
            $components[$componentName]['component']['backgroundClass'] = implode(' ', $components[$componentName]['component']['backgroundClass']);
            $components[$componentName]['component']['componentClass'] = implode(' ', $components[$componentName]['component']['componentClass']);
        }

        return $components;
    }

    public function componentStyles($components)
    {
        $expected_styles = [
            'backgroundImageUrl',
            //'sectionStyle',
        ];

        foreach ($components as $componentName => $component) {
            if (!empty($component['component']['backgroundImageUrl'])) {
                //$component['component']['backgroundImageUrl'] = "background-image:url('".$component['component']['backgroundImageUrl']."');";
                $components[$componentName]['component']['backgroundImageUrl'] = "style=\"background-image:url('".$component['component']['backgroundImageUrl']."');\"";
            }

            // Forcing a space delimeter
            foreach ($component['component'] as $option => $style) {
                if (in_array($option, $expected_styles)) {
                    $styles[$componentName][] = $style;
                    //$components[$componentName]['component']['componentStyle'] = "style=\"".implode(' ', $styles[$componentName])."\"";
                }
            }
        }

        return $components;
    }

    /**
     * {@inheritdoc}
     */
    public function legacyPageFieldSupport(array $data)
    {
        // Legacy support for accordion
        if (!empty($data['data']['accordion_promo_group_id'])) {
            $data['data']['modular-accordion-999'] = json_encode([
                'id' => $data['data']['accordion_promo_group_id']
            ]);
        }

        // Legacy support for listing
        if (!empty($data['data']['listing_promo_group_id'])) {
            if (!empty($data['data']['promotion_view_boolean']) && $data['data']['promotion_view_boolean'] === "true") {
                $data['data']['modular-catalog-998'] = json_encode([
                    'id' => $data['data']['listing_promo_group_id'],
                    'columns' => 1,
                    'singlePromoView' => true
                ]);
            } else {
                $data['data']['modular-catalog-998'] = json_encode([
                    'id' => $data['data']['listing_promo_group_id'],
                    'columns' => 1
                ]);
            }
        }

        // Legacy support for grid
        if (!empty($data['data']['grid_promo_group_id'])) {
            if (!empty($data['data']['promotion_view_boolean']) && $data['data']['promotion_view_boolean'] === "true") {
                $data['data']['modular-catalog-999'] = json_encode([
                    'id' => $data['data']['grid_promo_group_id'],
                    'columns' => 3,
                    'singlePromoView' => true
                ]);
            } else {
                $data['data']['modular-catalog-999'] = json_encode([
                    'id' => $data['data']['grid_promo_group_id'],
                    'columns' => 3
                ]);
            }
        }

        return $data;
    }
}
