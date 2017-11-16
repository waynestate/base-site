<?php

namespace Styleguide\Pages;

class News extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, [
            'site' => [
                'subsite-folder' => 'styleguide/',
            ],
            'page' => [
                'controller' => 'NewsController',
                'title' => 'News Listing',
                'id' => 101102,
                'content' => [
                    'main' => '',
                ],
            ],
            'menu' => [
                'id' => 1,
            ],
        ]);
    }
}
