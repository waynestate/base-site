<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ComponentButtonsLarge extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ComponentButtonsController',
                'title' => 'Large buttons',
                'id' => 114100200,
                'content' => [
                    'main' => '',
                ],
            ],
        ]);
    }
}
