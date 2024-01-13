<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class HeroFull extends Page
{
    /** {@inheritdoc} **/
    public $path = '/styleguide/hero/full';

    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'HeroController',
                'title' => 'Hero full  width',
                'id' => 105100103,
                'content' => [
                    'main' => '',
                ],
            ],
        ]);
    }
}
