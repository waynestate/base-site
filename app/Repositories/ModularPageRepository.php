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

    /**
     * Construct the repository.
     *
     * @param Connector $wsuApi
     * @param ParsePromos $parsePromos
     * @param Repository $cache
     * @param ArticleRepositoryContract $article
     * @param EventRepositoryContract $event
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

        return $components;
    }

    public function parseData(array $data)
    {
        $components = [];
        $group_reference = [];
        $group_config = [];

        foreach ($data['data'] as $pageField => $value) {
            if (Str::startsWith($pageField, 'modular-')) {
                $name = Str::replaceFirst('modular-', '', $pageField);

                // Remove all spaces and line breaks
                $value = preg_replace('/\s*\R\s*/', '', $value);

                // Last item cannot have comma at the end of it
                $value = preg_replace('(,})', '}', $value);

                if (Str::startsWith($value, '{')) {
                    $components[$name] = json_decode($value, true);
                    if (!empty($components[$name]['config'])) {
                        $config = explode('|', $components[$name]['config']);
                        // Add youtube
                        if (strpos($components[$name]['config'], 'youtube') === false) {
                            array_push($config, 'youtube');
                        }
                        foreach ($config as $key => $value) {
                            if (Str::startsWith($value, 'page_id')) {
                                $config[$key] = 'page_id:'.$data['page']['id'];
                            }

                            if (Str::startsWith($value, 'first')) {
                                unset($config[$key]);
                            }
                        }
                        $components[$name]['config'] = implode('|', $config);
                    }
                    $components[$name]['filename'] = preg_replace('/-\d+$/', '', $name);
                } else {
                    $components[$name]['id'] = (int)$value;
                }

                if (!Str::startsWith($name, ['events', 'news']) && !empty($components[$name]['id'])) {
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

        // TODO Allowing the use of another site's promo items only from base
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
                $item = $this->adjustPromoData($item, $components['components'][$name]);

                return $item;
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
            if (array_key_exists($name, $promos)) {
                // Assign promo data to components
                $modularComponents[$name]['data'] = $promos[$name]['data'] ?? [];
                $modularComponents[$name]['component'] = $promos[$name]['component'] ?? [];

                if (Str::contains($name, 'social')) {
                    $photo = current($modularComponents[$name]['data']);
                    $modularComponents[$name]['data'] = [];
                    $social_feed = $this->socialfeed->getSocialFeed($component['labelId'], $component['limit'] ?? 6, '');
                    $modularComponents[$name]['data']['photo'] = $photo;
                    $modularComponents[$name]['data']['social-feed'] = $social_feed['social_feed'];
                    $modularComponents[$name]['component'] = $components['components'][$name];
                }
            } elseif (Str::contains($name, 'events')) {
                $events_id = config('base.events_id') ?? $data['site']['id'];
                $events_path = !empty($data['site']['events']['path']) ? $data['site']['events']['path'] : config('base.events_path');
                $calendarURL = $component['cal_name'] ?? $events_path ?? '';
                $components['components'][$name]['id'] = $component['id'] ?? $events_id;
                $limit = $components['components'][$name]['limit'] ?? 4;
                if (strpos($name, 'events-column') !== false) {
                    $events = $this->event->getEvents($component['id'] ?? $events_id, $limit);
                } elseif (!empty($component['title']) && !empty($component['heading'])) {
                    $events = $this->event->getEventsByTitle($component['id'] ?? $events_id, $component['heading'] ?? 'Events', $component['title'] ?? 'All events', $limit);
                } else {
                    $events = $this->event->getEventsFullListing($component['id'] ?? $events_id, $limit);
                }
                $modularComponents[$name]['data'] = $events['events'] ?? [];
                $modularComponents[$name]['component'] = $components['components'][$name];
                $modularComponents[$name]['component']['cal_name'] = $calendarURL;
            } elseif (Str::contains($name, 'news')) {
                $components['components'][$name]['id'] = $component['id'] ?? $data['site']['news']['application_id'];
                $limit = $component['limit'] ?? 4;
                $components['components'][$name]['news_route'] = $component['news_route'] ?? config('base.news_listing_route');
                if (!empty($component['featured']) && $component['featured'] === true) {
                    $articles = $this->article->listing($components['components'][$name]['id'], 50, 1, $component['topics'] ?? []);
                    $articles['articles']['data'] = collect($articles['articles']['data'])->filter(function ($article) {
                        return !empty($article['featured']['featured']) && $article['featured']['featured'] === 1;
                    })->take($limit)->toArray();
                } else {
                    $articles = $this->article->listing($components['components'][$name]['id'], $limit, 1, $component['topics'] ?? []);
                }
                $modularComponents[$name]['data'] = $articles['articles'] ?? [];
                $modularComponents[$name]['component'] = $components['components'][$name];
            } elseif(Str::contains($name, 'social-feed-grid')) {
                $social_feed = $this->socialfeed->getSocialFeed($component['labelId'], $component['limit'] ?? 16, '');
                $modularComponents[$name]['data']['social-feed'] = $social_feed['social_feed'];
                $modularComponents[$name]['component'] = $components['components'][$name];
            } else {
                // If there's JSON but no news, events or promo data, assign the component array as data
                $modularComponents[$name]['data'][] = $components['components'][$name] ?? [];
                $modularComponents[$name]['component'] = $components['components'][$name] ?? [];

                if (Str::startsWith($name, 'heading')) {
                    unset($modularComponents[$name]['component']['heading']);
                }
            }

            if (Str::contains($name, 'spotlight') && (!empty($component['accessId']) || !empty($component['accessIds']))) {
                $accessIds = explode(',', strip_tags($component['accessId'] ?? $component['accessIds']));
                $spotlightProfiles = $this->profile->getSpotlightProfileByAccessId($accessIds, $component['limit'] ?? 6);
                $spotlightPromos = !empty(array_column($modularComponents[$name]['data'], 'promo_item_id')) ? $modularComponents[$name]['data'] : [];
                $mergedProfilesAndPromos = $spotlightPromos + $spotlightProfiles;
                shuffle($mergedProfilesAndPromos);
                $modularComponents[$name]['data'] = $mergedProfilesAndPromos;
            }
        }

        return $modularComponents;
    }

    /**
     * {@inheritdoc}
     */
    public function configureComponents(array $components, array $promos, array $data): array
    {
        $modularComponents = [];

        foreach ($components['components'] as $name => $component) {
            if (array_key_exists($name, $promos)) {
                // Assign promo data to components
                $modularComponents[$name]['data'] = $promos[$name]['data'] ?? [];
                $modularComponents[$name]['component'] = $promos[$name]['component'] ?? [];

                if (Str::contains($name, 'social')) {
                    $photo = current($modularComponents[$name]['data']);
                    $modularComponents[$name]['data'] = [];
                    $social_feed = $this->socialfeed->getSocialFeed($component['labelId'], $component['limit'] ?? 6, '');
                    $modularComponents[$name]['data']['photo'] = $photo;
                    $modularComponents[$name]['data']['social-feed'] = $social_feed['social_feed'];
                    $modularComponents[$name]['component'] = $components['components'][$name];
                }
            } elseif (Str::contains($name, 'events')) {
                $events_id = config('base.events_id') ?? $data['site']['id'];
                $events_path = !empty($data['site']['events']['path']) ? $data['site']['events']['path'] : config('base.events_path');
                $calendarURL = $component['cal_name'] ?? $events_path ?? '';
                $components['components'][$name]['id'] = $component['id'] ?? $events_id;
                $limit = $components['components'][$name]['limit'] ?? 4;
                if (strpos($name, 'events-column') !== false) {
                    $events = $this->event->getEvents($component['id'] ?? $events_id, $limit);
                } elseif (!empty($component['title']) && !empty($component['heading'])) {
                    $events = $this->event->getEventsByTitle($component['id'] ?? $events_id, $component['heading'] ?? 'Events', $component['title'] ?? 'All events', $limit);
                } else {
                    $events = $this->event->getEventsFullListing($component['id'] ?? $events_id, $limit);
                }
                $modularComponents[$name]['data'] = $events['events'] ?? [];
                $modularComponents[$name]['component'] = $components['components'][$name];
                $modularComponents[$name]['component']['cal_name'] = $calendarURL;
            } elseif (Str::contains($name, 'news')) {
                $components['components'][$name]['id'] = $component['id'] ?? $data['site']['news']['application_id'];
                $limit = $component['limit'] ?? 4;
                $components['components'][$name]['news_route'] = $component['news_route'] ?? config('base.news_listing_route');
                if (!empty($component['featured']) && $component['featured'] === true) {
                    $articles = $this->article->listing($components['components'][$name]['id'], 50, 1, $component['topics'] ?? []);
                    $articles['articles']['data'] = collect($articles['articles']['data'])->filter(function ($article) {
                        return !empty($article['featured']['featured']) && $article['featured']['featured'] === 1;
                    })->take($limit)->toArray();
                } else {
                    $articles = $this->article->listing($components['components'][$name]['id'], $limit, 1, $component['topics'] ?? []);
                }
                $modularComponents[$name]['data'] = $articles['articles'] ?? [];
                $modularComponents[$name]['component'] = $components['components'][$name];
            } elseif(Str::contains($name, 'social-feed-grid')) {
                $social_feed = $this->socialfeed->getSocialFeed($component['labelId'], $component['limit'] ?? 16, '');
                $modularComponents[$name]['data']['social-feed'] = $social_feed['social_feed'];
                $modularComponents[$name]['component'] = $components['components'][$name];
            } else {
                // If there's JSON but no news, events or promo data, assign the component array as data
                $modularComponents[$name]['data'][] = $components['components'][$name] ?? [];
                $modularComponents[$name]['component'] = $components['components'][$name] ?? [];

                if (Str::startsWith($name, 'heading')) {
                    unset($modularComponents[$name]['component']['heading']);
                }
            }

            if (Str::contains($name, 'spotlight') && (!empty($component['accessId']) || !empty($component['accessIds']))) {
                $accessIds = explode(',', strip_tags($component['accessId'] ?? $component['accessIds']));
                $spotlightProfiles = $this->profile->getSpotlightProfileByAccessId($accessIds, $component['limit'] ?? 6);
                $spotlightPromos = !empty(array_column($modularComponents[$name]['data'], 'promo_item_id')) ? $modularComponents[$name]['data'] : [];
                $mergedProfilesAndPromos = $spotlightPromos + $spotlightProfiles;
                shuffle($mergedProfilesAndPromos);
                $modularComponents[$name]['data'] = $mergedProfilesAndPromos;
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
