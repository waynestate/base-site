<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ComponentLayoutConfig extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ComponentLayoutConfigController',
                'title' => 'Layout config',
                'id' => 124100,
                'content' => [
                    'main' => '',
                ],
            ],
        ]);
    }
}
