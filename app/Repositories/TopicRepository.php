<?php

namespace App\Repositories;

use Waynestate\Api\News;
use Waynestate\Api\Connector;
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
}
