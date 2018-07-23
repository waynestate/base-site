<?php

namespace Styleguide\Pages;

class NewsCategory extends Page
{
    /** {@inheritdoc} **/
    public $path = '/styleguide/news/category/est-quisquam';

    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'NewsController',
                'title' => 'News by category',
                'id' => null,
            ],
        ]);
    }
}
