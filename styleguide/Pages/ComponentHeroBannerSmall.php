<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ComponentHeroBannerSmall extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ComponentHeroController',
                'title' => 'Hero banner small',
                'id' => 105100108,
                'content' => [
                    'main' => '',
                ],
            ],
        ]);
    }
}
