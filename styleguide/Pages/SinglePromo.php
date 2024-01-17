<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class SinglePromo extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'SinglePromoController',
                'title' => 'Single promo',
                'id' => 116100,
                'content' => [
                    'main' => '<p>Single promo item with image or video.</p>',
                ],
            ],
        ]);
    }
}
