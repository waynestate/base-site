<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class HeroHalf extends Page
{
    /** {@inheritdoc} **/
    public $path = '/styleguide/hero/half';

    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'HeroController',
                'title' => 'Hero half',
                'id' => 105100109,
                'content' => [
                    'main' => '',
                ],
            ],
        ]);
    }
}
