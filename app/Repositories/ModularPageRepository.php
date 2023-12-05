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
        if(empty($data['data'])) {
            return [];
        }

        $modularComponents = [];

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

        $components = $this->parseData($data);
        $promos = $this->getPromos($components);

        foreach($components['components'] as $name => $component) {
            if(Str::startsWith($name, 'events')) {
                $components['components'][$name]['id'] = $component['id'] ?? $data['site']['id'];
                $events = $this->event->getEvents($component['id'] ?? $data['site']['id']);
                $modularComponents[$name]['data'] = $events['events'] ?? [];
                $modularComponents[$name]['component'] = $components['components'][$name];
                if (empty($modularComponents[$name]['component']['cal_name']) && !empty($data['site']['events']['path'])) {
                    $modularComponents[$name]['component']['cal_name'] = $data['site']['events']['path'];
                }
            } elseif(Str::startsWith($name, 'news')) {
                $components['components'][$name]['id'] = $component['id'] ?? $data['site']['news']['application_id'];
                $components['components'][$name]['limit'] = $component['limit'] ?? 4;
                $components['components'][$name]['news_route'] = $component['news_route'] ?? config('base.news_listing_route');
                if (!empty($component['featured']) && $component['featured'] === true) {
                    $articles = $this->article->listing($components['components'][$name]['id'], 50, 1, $component['topics'] ?? []);
                    $articles['articles']['data'] = collect($articles['articles']['data'])->filter(function ($article) {
                        return !empty($article['featured']['featured']) && $article['featured']['featured'] === 1;
                    })->take($component['limit'] ?? 4)->toArray();
                } else {
                    $articles = $this->article->listing($components['components'][$name]['id'], $component['limit'] ?? 4, 1, $component['topics'] ?? []);
                }
                $modularComponents[$name]['data'] = $articles['articles'] ?? [];
                $modularComponents[$name]['component'] = $components['components'][$name];
            } else {
                $modularComponents[$name]['data'] = $promos[$name]['data'] ?? [];
                $modularComponents[$name]['component'] = $promos[$name]['component'] ?? [];
            }
        }

        return $modularComponents;
    }

    public function parseData(array $data)
    {
        $components = [];
        $group_reference = [];
        $group_config = [];

        foreach($data['data'] as $pageField => $value) {
            if(Str::startsWith($pageField, 'modular-')) {
                $name = Str::replaceFirst('modular-', '', $pageField);

                // Remove all spaces and line breaks
                $value = preg_replace('/\s*\R\s*/', '', $value);

                // Last item cannot have comma at the end of it
                $value = preg_replace('(,})', '}', $value);

                //if(Str::isJson($value)) { // this isn't working, integers are considered json with this
                if(Str::startsWith($value, '{')) {
                    $components[$name] = json_decode($value, true);
                    if(!empty($components[$name]['config'])) {
                        $config = explode('|', $components[$name]['config']);
                        foreach($config as $key => $value) {
                            if(Str::startsWith($value, 'page_id')) {
                                $config[$key] = 'page_id:'.$data['page']['id'];
                            }

                            if(Str::startsWith($value, 'first')) {
                                unset($config[$key]);
                            }
                        }
                        $components[$name]['config'] = implode('|', $config);
                    }
                    $components[$name]['filename'] = preg_replace('/-\d+$/', '', $name);
                } else {
                    $components[$name]['id'] = (int)$value;
                }

                if(!Str::startsWith($name, ['events', 'news']) && !empty($components[$name]['id'])) {
                    $group_reference[$components[$name]['id']] = $name;
                    if(!empty($components[$name]['config'])) {
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

    public function getPromos($components)
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

        $promos = $this->parsePromos->parse($promos, $components['group_reference'], $components['group_config']);

        foreach ($promos as $name => $data) {
            $promos[$name] = [
                'data' => $data,
                'component' => $components['components'][$name],
            ];

            foreach($promos[$name]['data'] as $key => $promo) {
                $promos[$name]['data'][$key] = $this->adjustPromoData($promo, $promos[$name]['component']);
            }
        }

        return $promos;
    }

    public function adjustPromoData($data, $component)
    {
        if(isset($component['singlePromoView']) && $component['singlePromoView'] === true) {
            $data['link'] = 'view/'.Str::slug($data['title']).'-'.$data['promo_item_id'];
        }

        if(isset($component['showExcerpt']) && $component['showExcerpt'] === false) {
            unset($data['excerpt']);
        }

        if(isset($component['showDescription']) && $component['showDescription'] === false) {
            unset($data['description']);
        }

        return $data;
    }
}
