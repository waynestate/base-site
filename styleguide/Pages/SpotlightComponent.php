<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class SpotlightComponent extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'SpotlightController',
                'title' => 'Spotlight',
                'id' => 119100,
                'content' => [
                    'main' => '<p>Single promo item for a quote with a citation and image.</p>',
                ],
            ],
        ]);
    }
}
