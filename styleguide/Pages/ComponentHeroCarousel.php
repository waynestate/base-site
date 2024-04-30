<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ComponentHeroCarousel extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'componentHeroController',
                'title' => 'Hero carousel',
                'id' => 105100104,
                'content' => [
                    'main' => '',
                ],
            ],
        ]);
    }
}
