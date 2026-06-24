<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ComponentTabs extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ComponentTabsController',
                'title' => 'Tabs',
                'id' => 99902,
                'content' => [
                    'main' => '',
                ],
            ],
        ]);
    }
}
