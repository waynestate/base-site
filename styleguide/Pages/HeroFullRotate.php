<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class HeroFullRotate extends Page
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
                'controller' => 'HeroFullController',
                'title' => 'Full width - Rotate',
                'id' => 105100104,
            ],
        ]);
    }
}
