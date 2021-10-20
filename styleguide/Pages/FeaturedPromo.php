<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class FeaturedPromo extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'FeaturedPromoController',
                'title' => 'Featured Promo',
                'id' => 116100,
            ],
        ]);
    }
}
