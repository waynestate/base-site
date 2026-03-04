<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ComponentHeroSvgoverlaycontained extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ComponentHeroController',
                'title' => 'Hero SVG overlay (Contained)',
                'id' => 105100113,
                'content' => [
                    'main' => '',
                ],
            ],
        ]);
    }
}
