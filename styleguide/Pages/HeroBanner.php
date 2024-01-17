<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class HeroBanner extends Page
{
    /** {@inheritdoc} **/
    public $path = '/styleguide/hero/banner';

    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'HeroController',
                'title' => 'Hero banner',
                'id' => 105100108,
                'content' => [
                    'main' => '',
                ],
            ],
        ]);
    }
}
