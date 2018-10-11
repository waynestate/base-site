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
    public function getCategories($site_id, $subsite=null, $prepend=false)
    {
        $categories['news_categories'] = app('Factories\NewsCategory')->create(5);

        $route = app('request')->route();

        // Change the last random category to be the one they selected
        if (!empty($route->parameters['slug'])) {
            $categories['news_categories'][5]['slug'] = $route->parameters['slug'];
            $categories['news_categories'][5]['category'] = str_replace('-', ' ', $route->parameters['slug']);
        }

        if ($prepend === true) {
            $categories['news_categories'] = collect($categories['news_categories'])->prepend([
                    'category_id' => null,
                    'slug' => null,
                    'category' => config('base.news_all_text'),
                    'link' => '/styleguide/'.config('base.news_listing_route').'/',
            ])->toArray();
        }

        return $categories;
    }
}
