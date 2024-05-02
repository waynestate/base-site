<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ComponentSpotlight extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ComponentSpotlightController',
                'title' => 'Spotlight',
                'id' => 119100,
                'content' => [
                    'main' => '',
                ],
            ],
        ]);
    }
}
