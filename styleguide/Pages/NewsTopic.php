<?php

namespace Styleguide\Pages;

class NewsTopic extends Page
{
    /** {@inheritdoc} **/
    public $path;

    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        $this->path = '/styleguide/'.config('base.news_listing_route').'/'.config('base.news_topic_route').'/est-quisquam';

        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'ArticleController',
                'title' => 'Articles by topic',
                'id' => 101102,
            ],
        ]);
    }
}
