<?php

namespace Styleguide\Repositories;

use App\Repositories\ArticleRepository as Repository;

class ArticleRepository extends Repository
{
    /**
     * {@inheritdoc}
     */
    public function listing($application_ids, $limit=5, $page=1, $topics=[])
    {
        return [
            'articles' => app('Factories\Article')->create(4),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function find($id, $application_ids)
    {
        return [
            'article' => app('Factories\Article')->create(1, true),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function topicsUrl()
    {
        return '/styleguide/'.config('base.news_listing_route').'/'.config('base.news_topics_route').'/';
    }
}
