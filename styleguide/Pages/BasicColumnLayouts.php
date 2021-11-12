<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class BasicColumnLayouts extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'BasicColumnLayoutsController',
                'title' => 'Basic Column Layouts',
                'id' => 100100,
            ],
        ]);
    }
}
