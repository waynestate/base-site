<?php

namespace Styleguide\Repositories;

use App\Repositories\ArticleRepository as Repository;
use Factories\Article;

class ArticleRepository extends Repository
{
    /**
     * {@inheritdoc}
     */
    public function listing($application_ids, $limit=5, $page=1, $topics=[])
    {
        // Stop the paging after page 3 so it doesn't go on forever
        $limit = $page >= 3 ? 5 : $limit;

        $articles['articles'] = app(Article::class)->create($limit);

        return $articles;
    }

    /**
     * {@inheritdoc}
     */
    public function find($id, $application_ids, $preview = null)
    {
        return [
            'article' => app(Article::class)->create(1, true),
        ];
    }
}
