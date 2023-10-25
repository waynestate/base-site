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

        $components = $this->parseData($data);
        $promos = $this->getPromos($components);

        foreach($components['components'] as $name => $component) {
            if(Str::startsWith($name, 'events')) {
                $events = $this->event->getEvents($component['id']);
                $modularComponents[$name]['data'] = $events['events'];
                $modularComponents[$name]['component'] = $components['components'][$name];
            } elseif(Str::startsWith($name, 'news')) {
                $articles = $this->article->listing($component['id']);
                $modularComponents[$name]['data'] = $articles['articles'];
                $modularComponents[$name]['component'] = $components['components'][$name];
            } else {
                $modularComponents[$name]['data'] = $promos[$name]['data'];
                $modularComponents[$name]['component'] = $promos[$name]['component'];
            }
        }
        dump($modularComponents);

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

                if(Str::isJson($value)) {
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

                if(!Str::startsWith($name, ['events', 'news'])) {
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
