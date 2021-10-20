<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class News extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ArticleController',
                'title' => 'News listing',
                'id' => 101102,
            ],
            'site' => [
                'news' => [
                    'application_id' => 1,
                ],
            ],
        ]);
    }
}
