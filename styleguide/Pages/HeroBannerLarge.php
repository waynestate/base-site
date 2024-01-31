<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class HeroBannerLarge extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'HeroController',
                'title' => 'Hero banner large',
                'id' => 105100103,
                'content' => [
                    'main' => '',
                ],
            ],
        ]);
    }
}
