<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ComponentsPageContent extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ComponentsPageContentController',
                'title' => 'Page content',
                'id' => 123100,
                'content' => [
                    'main' => '',
                ],
            ],
        ]);
    }
}
