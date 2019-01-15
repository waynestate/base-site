<?php

namespace Styleguide\Pages;

class NewsCategory extends Page
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
                'controller' => 'AeticleController',
                'title' => 'Articles by topic',
                'id' => null,
            ],
        ]);
    }
}
