<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ComponentHeroBannerLarge extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ComponentHeroController',
                'title' => 'Hero banner large',
                'id' => 105100103,
                'content' => [
                    'main' => '',
                ],
            ],
        ]);
    }
}
