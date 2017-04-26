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
        $news['news'] = app('Factories\NewsItem')->create(4);

        return $news;
    }

    /**
     * {@inheritdoc}
     */
    public function getNewsByPage($site_id, $page = 0, $limit = 25, $category_id = null)
    {
        // Stop the paging after page 2 so it doesn't go on forever
        $limit = $page == 2 ? 5 : 25;

        $news['news'] = app('Factories\NewsItem')->create($limit);

        return $news;
    }

    /**
     * {@inheritdoc}
     */
    public function getNewsItem($id, $site_id)
    {
        $news['news'] = app('Factories\NewsItem')->create(1);

        return $news;
    }

    /**
     * {@inheritdoc}
     */
    public function getCategories($site_id)
    {
        $categories['news_categories'] = app('Factories\NewsCategory')->create(5);

        $route = app('request')->route();

        // Change the first random category to be the one they selected
        if (isset($route[2]['slug'])) {
            $categories['news_categories'][1]['slug'] = $route[2]['slug'];
            $categories['news_categories'][1]['category'] = str_replace('-', ' ', $route[2]['slug']);
        }

        return $categories;
    }
}
