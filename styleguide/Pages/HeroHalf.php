<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class HeroHalf extends Page
{
    /** {@inheritdoc} **/
    public $path = '/styleguide/hero/skinny';

    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'HeroController',
                'title' => 'Half',
                'id' => 105100109,
                'content' => [
                    'main' => '',
                ],
            ],
        ]);
    }
}