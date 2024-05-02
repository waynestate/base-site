<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ComponentHeroSVGOverlay extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ComponentHeroController',
                'title' => 'Hero SVG overlay',
                'id' => 105100106,
                'content' => [
                    'main' => '',
                ],
            ],
        ]);
    }
}
