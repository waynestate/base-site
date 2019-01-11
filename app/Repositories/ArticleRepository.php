<?php

namespace App\Repositories;

use Waynestate\Api\News;
use Waynestate\Api\Connector;
use Illuminate\Cache\Repository;
use Contracts\Repositories\ArticleRepositoryContract;

class ArticleRepository implements ArticleRepositoryContract
{
    /** @var News */
    protected $articleApi;

    /** @var Repository */
    protected $cache;

    /**
     * Construct the repository.
     *
     * @param news $articleApi
     * @param Repository $cache
     */
    public function __construct(News $articleApi, Repository $cache)
    {
        $this->articleApi = $articleApi;
        $this->cache = $cache;
    }

    /**
     * {@inheritdoc}
     */
    public function listing($application_ids, $limit=5, $page=1, $topics=[])
    {
        $params = [
            'perPage' =>  $limit,
            'page' => $page,
            'application_ids' => $application_ids,
            //'exclude_topics' => [],
            'method' => 'articles',
        ];

        if (!empty($topics)) {
            $params['method'] = 'articles/topics';
            $params['topics'] = $topics;
        }

        $articles['articles'] = $this->cache->remember($params['method'].md5(serialize($params)), config('cache.ttl'), function () use ($params) {
            $items = $this->articleApi->request($params['method'], $params);

            if (!empty($items['data'])) {
                $items['data'] = collect($items['data'])->map(function ($item) {
                    return $this->setNewsLink($item);
                })->toArray();
            }

            return $items;
        });

        return $articles;
    }

    public function find($id, $application_ids)
    {
        $params = [
            'method' => 'articles/'.$id,
            'application_ids' => $application_ids,
        ];

        $article['article'] = $this->cache->remember($params['method'].md5(serialize($params)), config('cache.ttl'), function () use ($id, $params) {
            return $this->articleApi->request($params['method'], $params);
        });

        if (!empty($article['article']['data'])) {
            $article['article']['data'] = current($article['article']['data']);
        }

        if (!empty($article['article']['data']['hero_image'])) {
            $article['article']['data']['hero_image'] = current($article['article']['data']['hero_image']);
        }

        if (!empty($article['article']['data']['main_image'])) {
            $article['article']['data']['main_image'] = current($article['article']['data']['main_image']);
        }

        return $article;
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
    public function getImageUrl($article)
    {
        // If the news item has an image attached
        if (!empty($article['hero_image']['url'])) {
            return $article['hero_image']['url'];
        }

        if (!empty($article['main_image']['url'])) {
            return $article['main_image']['url'];
        }

        // Scan the news body for the first image
        $doc = new \DOMDocument();
        @$doc->loadHTML($article['body']);
        $images = $doc->getElementsByTagName('img');

        if ($images->item(0) !== null) {
            return $images->item(0)->getAttribute('src');
        }

        return null;
    }

    /**
     * {@inheritdoc}
     */
    public function setNewsLink($item)
    {
        if (empty($item['link'])) {
            $item['link'] = '/'.config('base.news_view_route').'/'.$item['permalink'].'-'.$item['id'];
        }

        return $item;
    }
}
