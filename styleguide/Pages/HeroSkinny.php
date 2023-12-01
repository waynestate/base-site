<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class HeroSkinny extends Page
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
                'controller' => 'HeroFullController',
                'title' => 'Skinny',
                'id' => 105100103,
                'content' => [
                    'main' => '<p></p>',
                ],
            ],
        ]);
    }
}
