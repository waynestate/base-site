<?php

namespace App\Repositories;

use Waynestate\Api\News;
use Illuminate\Cache\Repository;
use Contracts\Repositories\TopicRepositoryContract;

class TopicRepository implements TopicRepositoryContract
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
    public function listing($application_ids, $subsite_folder = null)
    {
        $params = [
            'application_ids' => $application_ids,
            'method' => 'topics',
        ];

        $topics['topics'] = $this->cache->remember('newsroom-topics', config('cache.ttl'), function () use ($params, $subsite_folder) {
            try {
                $topics = $this->newsApi->request($params['method'], $params);
            } catch (\Exception $e) {
                $topics = [];
            }

            $all_topics = [
                'topic_id' => '0',
                'name' => 'All topics',
                'slug' => '',
                'url' => '/'.(!empty($subsite_folder) ? $subsite_folder : '').config('base.news_listing_route'),
            ];

            if (!empty($topics['data'])) {
                $topics['data'] = collect($topics['data'])->map(function ($topic) use ($subsite_folder) {
                    $topic['url'] = '/'.(!empty($subsite_folder) ? $subsite_folder : '').config('base.news_listing_route').'/'.config('base.news_topic_route').'/'.$topic['slug'];

                    return $topic;
                })->prepend($all_topics)->toArray();
            }

            return $topics;
        });

        return $topics;
    }

    /**
     * {@inheritdoc}
     */
    public function find($slug)
    {
        $params = [
            'method' => 'topic/'.$slug,
        ];

        $topic['topic'] = $this->cache->remember($params['method'].md5(serialize($params)), config('cache.ttl'), function () use ($params) {
            return $this->newsApi->request($params['method'], $params);
        });

        return $topic;
    }

    /**
     * {@inheritdoc}
     */
    public function sortByLetter($topics)
    {
        $sorted = [];

        // Sort topics by letter
        if (!empty($topics)) {
            foreach ($topics as $item) {
                $sorted[substr($item['name'], 0, 1)][] = $item;
            }

            ksort($sorted);
        }

        return $sorted;
    }

    /**
     * {@inheritdoc}
     */
    public function setSelected($topics, $topic)
    {
        return collect($topics)->map(function ($item) use ($topic) {
            $item['selected'] = $item['slug'] === $topic ? true : false;

            return $item;
        })->toArray();
    }
}
