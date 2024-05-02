<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ComponentPageContent extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ComponentPageContentController',
                'title' => 'Page content',
                'id' => 123100,
                'content' => [
                    'main' => '',
                ],
            ],
        ]);
    }
}
