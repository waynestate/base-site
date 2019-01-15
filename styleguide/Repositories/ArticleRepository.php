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
        // Stop the paging after page 3 so it doesn't go on forever
        $limit = $page >= 3 ? 5 : 25;

        $articles['articles'] = app('Factories\Article')->create($limit);

        if(empty($page)) {
            $next_page_url = null;
            $prev_page_url = '/styleguide/'.config('base.news_view_route').'?page=2';
        }elseif($page >=3) {
            $next_page_url = '/styleguide/'.config('base.news_view_route').'?page='.($page-1);
            $prev_page_url = null;
        }else{
            $next_page_url = '/styleguide/'.config('base.news_view_route').(($page-1 == 1) ? '' : '?page='.($page-1));
            $prev_page_url = '/styleguide/'.config('base.news_view_route').'/?page='.($page+1);
        }

        $articles['articles']['meta'] = [
            'total' => 55,
            'current_page' => $page,
            'prev_page_url' => $prev_page_url,
            'next_page_url' => $next_page_url,
        ];

        return $articles;
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
