<?php

namespace Styleguide\Pages;

class View extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'PromoListingController',
                'title' => 'Promo view',
                'id' => 101110300,
            ],
        ]);
    }
}
