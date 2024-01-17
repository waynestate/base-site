<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class HeroTextOverlay extends Page
{
    /** {@inheritdoc} **/
    public $path = '/styleguide/hero/textoverlay';

    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'HeroController',
                'title' => 'Hero text overlay',
                'id' => 105100105,
                'content' => [
                    'main' => '',
                ],
            ],
        ]);
    }
}
