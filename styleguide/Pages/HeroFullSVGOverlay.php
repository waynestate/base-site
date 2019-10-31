<?php

namespace Styleguide\Pages;

class HeroFullSVGOverlay extends Page
{
    /** {@inheritdoc} **/
    public $path = '/styleguide/hero/full/svgoverlay';

    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'HeroFullSVGOverlayController',
                'title' => 'Full width (SVG overlay)',
                'id' => 105100108,
            ],
        ]);
    }
}
