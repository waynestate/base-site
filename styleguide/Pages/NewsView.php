<?php

namespace Styleguide\Pages;

class NewsView extends Page
{
    /** {@inheritdoc} **/
    public $path = '/styleguide/news/item-1';

    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'NewsController',
                'title' => 'News View',
                'id' => null,
            ],
        ]);
    }
}
