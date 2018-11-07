<?php

namespace App\Repositories;

use Contracts\Repositories\NewsRepositoryContract;
use Illuminate\Cache\Repository;
use Waynestate\Api\Connector;
use Waynestate\Promotions\ParsePromos;

class NewsRepository implements NewsRepositoryContract
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
     */
    public function __construct(Connector $wsuApi, ParsePromos $parsePromos, Repository $cache)
    {
        $this->wsuApi = $wsuApi;
        $this->parsePromos = $parsePromos;
        $this->cache = $cache;
    }

    /**
     * {@inheritdoc}
     */
    public function getNewsByDisplayOrder($site_id)
    {
        $params = [
            'method' => 'cms.news.listing',
            'sites' => [$site_id],
            'is_active' => '1',
            'limit' => 4,
            'order_by' => 'display_order',
            'sort' => 'ASC',
            'server_location' => 'both',
            'server' => config('app.env'),
            'fields' => 'news_id|title|link|posted|app_id|slug|filename',
            'before' => 'now',
        ];

        $news_listing = $this->cache->remember($params['method'].md5(serialize($params)), config('cache.ttl'), function () use ($params) {
            $items = $this->wsuApi->sendRequest($params['method'], $params);

            if (!empty($items['news'])) {
                $items['news'] = collect($items['news'])->map(function ($item) {
                    return $this->setNewsLink($item);
                })->toArray();
            }

            return $items;
        });

        // Make sure the return is an array
        $news['news'] = array_get($news_listing, 'news', []);

        return $news;
    }

    /**
     * {@inheritdoc}
     */
    public function getNewsByPage($site_id, $page = 0, $limit = 25, $category_id = null)
    {
        $params = [
            'method' => 'cms.news.listing',
            'sites' => [$site_id],
            'is_active' => '1',
            'order_by' => 'posted',
            'sort' => 'DESC',
            'fields' => 'news_id|title|link|posted|app_id|slug|excerpt|filename',
            'server_location' => 'both',
            'server' => config('app.env'),
            'limit' => $limit,
            'archive' => '1',
            'offset' => ($page != '' ? $page * $limit : 0),
            'category_id' => $category_id !== null ? $category_id : '',
        ];

        return $this->cache->remember($params['method'].md5(serialize($params)), config('cache.ttl'), function () use ($params) {
            $items = $this->wsuApi->sendRequest($params['method'], $params);

            if (!empty($items['news'])) {
                $items['news'] = collect($items['news'])->map(function ($item) {
                    return $this->setNewsLink($item);
                })->toArray();
            }

            return $items;
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getNewsItem($id, $site_id)
    {
        $params = [
            'method' => 'cms.news.info',
            'sites' => [$site_id],
            'news_id' => $id,
            'is_active' => '1',
            'order_by' => 'posted',
            'sort' => 'DESC',
            'server_location' => 'both',
            'server' => config('app.env'),
            'limit' => 1,
        ];

        return $this->cache->remember($params['method'].md5(serialize($params)), config('cache.ttl'), function () use ($params) {
            return $this->wsuApi->sendRequest($params['method'], $params);
        });
    }

    /**
     * {@inheritdoc}
     */
    public function getPaging($page = 0, $limit = 25)
    {
        return [
            'paging' => [
                'perPage' => $limit,
                'page_number_previous' => $page + 1,
                'page_number_next' => $page - 1,
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getCategories($site_id, $subsite=null, $prepend=false)
    {
        $params = [
            'method' => 'cms.news.categories',
            'site_id' => $site_id,
            'is_active' => 1,
        ];

        $categories = $this->cache->remember($params['method'].md5(serialize($params)), config('cache.ttl'), function () use ($params) {
            return $this->wsuApi->sendRequest($params['method'], $params);
        });

        $categories['news_categories'] = collect($categories['news_categories'])->map(function ($item) use ($subsite) {
            $item['link'] = '/'.(!empty($subsite) ? $subsite : '').config('base.news_listing_route').'/'.config('base.news_filter_route').'/'.$item['slug'];

            return $item;
        })->toArray();

        if ($prepend === true) {
            $categories['news_categories'] = collect($categories['news_categories'])->prepend([
                    'category_id' => null,
                    'slug' => null,
                    'category' => config('base.news_all_text'),
                    'link' => '/'.config('base.news_listing_route').'/',
            ])->toArray();
        }

        return $categories;
    }

    /**
     * {@inheritdoc}
     */
    public function setSelectedCategory($categories, $slug)
    {
        $categories['selected_news_category']['category_id'] = null;

        foreach ($categories['news_categories'] as $key => $category) {
            if (!empty($slug) && $category['slug'] == $slug) {
                $categories['selected_news_category'] = $category;
            }
        }

        return $categories;
    }

    /**
     * {@inheritdoc}
     */
    public function getImageUrl($news)
    {
        // If the news item has an image attached
        if (!empty($news['news']['filename'])) {
            return $news['news']['filename'];
        }

        // Scan the news body for the first image
        $doc = new \DOMDocument();
        @$doc->loadHTML($news['news']['body']);
        $images = $doc->getElementsByTagName('img');

        if ($images->item(0) !== null) {
            return $images->item(0)->getAttribute('src');
        }

        return null;
    }

    /**
     * Set the news link according to the news view route.
     *
     * @param array $item
     * @return array
     */
    public function setNewsLink($item)
    {
        $item['full_link'] = str_replace('/news/', '/'.config('base.news_view_route').'/', $item['full_link']);

        return $item;
    }
}
