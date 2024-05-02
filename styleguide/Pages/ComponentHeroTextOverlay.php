<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ComponentHeroTextOverlay extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ComponentHeroController',
                'title' => 'Hero text overlay',
                'id' => 105100105,
                'content' => [
                    'main' => '',
                ],
            ],
        ]);
    }
}
