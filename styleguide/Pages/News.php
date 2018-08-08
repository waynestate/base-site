<?php

namespace Styleguide\Pages;

class News extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'NewsController',
                'title' => 'News listing',
                'id' => 101102,
            ],
        ]);
    }
}
