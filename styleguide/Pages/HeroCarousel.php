<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class HeroCarousel extends Page
{
    /** {@inheritdoc} **/
    public $path = '/styleguide/hero/carousel';

    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'HeroController',
                'title' => 'Hero carousel',
                'id' => 105100104,
                'content' => [
                    'main' => '',
                ],
            ],
        ]);
    }
}
