<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ChildpageWithComponents extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ChildpageController',
                'title' => 'Childpage with components',
                'id' => 101110700,
                'content' => [
                    'main' => '<p>Normal page content from the CMS will show up here and components will display below.</p>',
                ],
            ],
            'site' => [
                'subsite-folder' => 'styleguide/',
                'news' => [
                    'application_id' => 1,
                ],
            ],
            'data' => [
                'modular-events-column-1' => 1,
                'events_url' => '/main',
                'modular-news-column-1' => 2,
                'buttons' => '{}',
                'image-promos' => '{}',
                'spotlight' => '{}',
                'steps' => '{}',
                'text-promo' => '{}',
                'video' => '{}',
            ],
        ]);
    }
}
