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
    public function listing($application_ids)
    {
        $params = [
            'application_ids' => $application_ids,
            'method' => 'topics',
        ];

        $topics['topics'] = $this->cache->remember('newsroom-topics', config('cache.ttl'), function () use ($params) {
            $topics = $this->newsApi->request($params['method'], $params);

            $topics['data'] = collect($topics['data'])->map(function ($topic) {
                $topic['url'] = '/'.config('base.news_listing_route').'/'.config('base.news_topic_route').'/'.$topic['slug'];

                return $topic;
            })->toArray();

            if (!empty($topics['data'])) {
                $topics['data'] = $this->sortByLetter($topics['data']);
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
     * Sort articles by letter
     *
     * @param array $topics
     * @return array
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
}
