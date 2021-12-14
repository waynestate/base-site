<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ArticleListing extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ArticleListingController',
                'title' => 'News article listing',
                'id' => 108100,
            ],
            'site' => [
                'subsite-folder' => 'styleguide/',
            ],
        ]);
    }
}
