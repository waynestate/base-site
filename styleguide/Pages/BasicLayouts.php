<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class BasicLayouts extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'BasicLayoutsController',
                'title' => 'Basic layouts',
                'id' => 100200,
            ],
        ]);
    }
}
