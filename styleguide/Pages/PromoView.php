<?php

namespace Styleguide\Pages;

class PromoView extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'PromoViewController',
                'title' => 'Promo view',
                'id' => 101110300,
            ],
        ]);
    }
}
