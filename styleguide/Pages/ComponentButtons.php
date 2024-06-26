<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ComponentButtons extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ComponentButtonsController',
                'title' => 'Button set',
                'id' => 114100,
                'content' => [
                    'main' => '',
                ],
            ],
        ]);
    }
}
