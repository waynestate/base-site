<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class HeroSVGOverlay extends Page
{
    /** {@inheritdoc} **/
    public $path = '/styleguide/hero/svgoverlay';

    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'HeroController',
                'title' => 'Hero SVG overlay',
                'id' => 105100106,
                'content' => [
                    'main' => '',
                ],
            ],
        ]);
    }
}
