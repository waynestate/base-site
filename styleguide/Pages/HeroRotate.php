<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class HeroRotate extends Page
{
    /** {@inheritdoc} **/
    public $path = '/styleguide/hero/rotate';

    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'HeroController',
                'title' => 'Rotate',
                'id' => 105100104,
                'content' => [
                    'main' => '',
                ],
            ],
        ]);
    }
}
