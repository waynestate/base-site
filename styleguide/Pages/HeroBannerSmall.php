<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class HeroBannerSmall extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'HeroController',
                'title' => 'Hero banner small',
                'id' => 105100108,
                'content' => [
                    'main' => '',
                ],
            ],
        ]);
    }
}
