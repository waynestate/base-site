<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ComponentHeroButtons extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ComponentHeroButtonsController',
                'title' => 'Hero buttons',
                'id' => 105100111,
                'content' => [
                    'main' => '',
                ],
            ],
        ]);
    }
}
