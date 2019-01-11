<?php

namespace App\Repositories;

use Waynestate\Api\News;
use Illuminate\Cache\Repository;
use Contracts\Repositories\TopicRepositoryContract;

class TopicRepository implements TopicRepositoryContract
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
    public function listing($application_ids)
    {
        $params = [
            'application_ids' => $application_ids,
            'method' => 'topics',
        ];

        $topics['topics'] = $this->cache->remember('newsroom-topics', config('cache.ttl'), function () use ($params) {
            return $this->articleApi->request($params['method'], $params);
        });

        return $topics;
    }

    /**
     * {@inheritdoc}
     */
    public function find($id, $slug)
    {
        $params = [
            'method' => 'topic/'.$slug,
        ];

        $topic['topic'] = $this->cache->remember($params['method'].md5(serialize($params)), config('cache.ttl'), function () use ($params) {
            return $this->articleApi->request($params['method'], $params);
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
        }

        return $sorted;
    }
}
