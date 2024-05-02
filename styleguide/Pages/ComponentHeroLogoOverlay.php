<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ComponentHeroLogoOverlay extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ComponentHeroController',
                'title' => 'Hero logo overlay',
                'id' => 105100107,
                'content' => [
                    'main' => '',
                ],
            ],
        ]);
    }
}
