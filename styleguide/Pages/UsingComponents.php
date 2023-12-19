<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class UsingComponents extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'UsingComponentsController',
                'title' => 'Using components',
                'id' => 101110600,
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
