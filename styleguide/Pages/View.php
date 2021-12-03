<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class View extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'PromoListingController',
                'title' => 'Promo view',
                'id' => 101110300,
            ],
        ]);
    }
}
