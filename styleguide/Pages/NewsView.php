<?php

namespace Styleguide\Pages;

class NewsView extends Page
{
    /** {@inheritdoc} **/
    public $path;

    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        $this->path = '/styleguide/'.config('base.news_listing_route').'/item-1';

        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'ArticleController',
                'title' => 'News View',
                'id' => null,
            ],
            'site' => [
                'news' => [
                    'application_id' => 1,
                ],
            ],
        ]);
    }
}
