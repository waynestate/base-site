<?php

namespace Styleguide\Pages;

class HeroFullTextOverlay extends Page
{
    /** {@inheritdoc} **/
    public $path = '/styleguide/hero/full/textoverlay';

    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'HeroFullTextOverlayController',
                'title' => 'Full width - Text overlay',
                'id' => 105100105,
            ],
        ]);
    }
}
