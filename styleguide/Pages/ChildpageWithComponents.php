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
                'controller' => 'ChildpageWithComponentsController',
                'title' => 'Childpage with components',
                'id' => 101110700,
                'content' => [
                    'main' => '',
                ],
            ],
            'site' => [
                'subsite-folder' => 'styleguide/',
                'news' => [
                    'application_id' => 1,
                ],
            ],
        ]);
    }
}
