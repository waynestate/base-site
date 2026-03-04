<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ComponentHeroLogooverlaycontained extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ComponentHeroController',
                'title' => 'Hero logo overlay (Contained)',
                'id' => 105100114,
                'content' => [
                    'main' => '',
                ],
            ],
        ]);
    }
}
