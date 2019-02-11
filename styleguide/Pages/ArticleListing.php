<?php

namespace Styleguide\Pages;

class ArticleListing extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'ArticleListingController',
                'title' => 'Article listing',
                'id' => 108100,
            ],
            'site' => [
                'subsite-folder' => 'styleguide/',
            ],
        ]);
    }
}
