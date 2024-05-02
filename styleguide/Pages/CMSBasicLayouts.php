<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class CMSBasicLayouts extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'CMSBasicLayoutsController',
                'title' => 'Basic responsive layouts',
                'id' => 100200,
            ],
        ]);
    }
}
