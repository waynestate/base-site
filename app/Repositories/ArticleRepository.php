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
                    return $this->setArticleLink($item);
                })->toArray();
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
}
