<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ComponentHeroTextOverlayContained extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ComponentHeroController',
                'title' => 'Hero text overlay (Contained)',
                'id' => 105100112,
                'content' => [
                    'main' => '',
                ],
            ],
        ]);
    }
}
