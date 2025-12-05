<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ComponentPageConfig extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ComponentPageConfigController',
                'title' => 'Page configuration',
                'id' => 124100,
                'content' => [
                    'main' => '<p>Page config.</p>',
                ],
            ],
        ]);
    }
}
