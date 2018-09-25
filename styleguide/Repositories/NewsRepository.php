<?php

namespace Styleguide\Repositories;

use App\Repositories\NewsRepository as Repository;

class NewsRepository extends Repository
{
    /**
     * {@inheritdoc}
     */
    public function getNewsByDisplayOrder($site_id)
    {
        return [
            'news' => app('Factories\NewsItem')->create(4),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getNewsByPage($site_id, $page = 0, $limit = 25, $category_id = null)
    {
        // Stop the paging after page 2 so it doesn't go on forever
        $limit = $page == 2 ? 5 : 25;

        return [
            'news' => app('Factories\NewsItem')->create($limit),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getNewsItem($id, $site_id)
    {
        return [
            'news' => app('Factories\NewsItem')->create(1, true),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function getCategories($site_id, $subsite=null)
    {
        $categories['news_categories'] = app('Factories\NewsCategory')->create(5);

        $route = app('request')->route();

        // Change the first random category to be the one they selected
        if (!empty($route->parameters['slug'])) {
            $categories['news_categories'][1]['slug'] = $route->parameters['slug'];
            $categories['news_categories'][1]['category'] = str_replace('-', ' ', $route->parameters['slug']);
        }

        return $categories;
    }
}
