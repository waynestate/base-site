<?php

namespace App\Repositories;

use Waynestate\Api\News;
use Illuminate\Cache\Repository;
use Contracts\Repositories\ArticleRepositoryContract;

class ArticleRepository implements ArticleRepositoryContract
{
    /** @var News */
    protected $newsApi;

    /** @var Repository */
    protected $cache;

    /**
     * Construct the repository.
     *
     * @param news $newsApi
     * @param Repository $cache
     */
    public function __construct(News $newsApi, Repository $cache)
    {
        $this->newsApi = $newsApi;
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
            'method' => 'articles',
        ];

        if (!empty($topics)) {
            $params['method'] = 'articles/topics';
            $params['topics'] = $topics;
        }

        $articles['articles'] = $this->cache->remember($params['method'].md5(serialize($params)), config('cache.ttl'), function () use ($params, $page) {
            $items = $this->newsApi->request($params['method'], $params);

            if (!empty($items['data'])) {
                $items['data'] = collect($items['data'])->map(function ($item) {
                    return $this->setArticleLink($item);
                })->toArray();
            }

            if(empty($page)) {
                $items['meta']['next_page_url'] = null;
                $items['meta']['prev_page_url'] = '/news?page=2';
            }elseif($page == $items['meta']['last_page']) {
                $items['meta']['next_page_url'] = '/news?page='.($page-1);
                $items['meta']['prev_page_url'] = null;
            }else{
                $items['meta']['next_page_url'] = '/news'.(($page-1 == 1) ? '' : '?page='.($page-1));
                $items['meta']['prev_page_url'] = '/news/?page='.($page+1);
            }

            return $items;
        });

        return $articles;
    }

    /**
     * {@inheritdoc}
     */
    public function find($id, $application_ids)
    {
        $params = [
            'method' => 'articles/'.$id,
            'application_ids' => $application_ids,
        ];

        $article['article'] = $this->cache->remember($params['method'].md5(serialize($params)), config('cache.ttl'), function () use ($params) {
            return $this->newsApi->request($params['method'], $params);
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
    public function setArticleLink($item)
    {
        if (empty($item['link'])) {
            $item['link'] = '/'.config('base.news_view_route').'/'.$item['permalink'].'-'.$item['id'];
        }

        return $item;
    }

    /**
     * {@inheritdoc}
     */
    public function topicsUrl()
    {
        return '/'.config('base.news_listing_route').'/'.config('base.news_topics_route').'/';
    }
}
