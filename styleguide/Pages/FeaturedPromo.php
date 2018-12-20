<?php

namespace Styleguide\Pages;

class FeaturedPromo extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'FeaturedPromoController',
                'title' => 'Featured Promo',
                'id' => 116100,
            ],
        ]);
    }
}
