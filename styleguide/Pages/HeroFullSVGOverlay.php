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
                'title' => 'Full width - SVG overlay',
                'id' => 105100106,
                'content' => [
                    'main' => '
                        <h2>Promo group setup</h2>
                        <p>Only available for full-width templates</p>
                        <ul>
                            <li><strong>Primary image:</strong> Background image</li>
                            <li><strong>Secondary image:</strong> Covers the entire background image</li>
                            <li><strong>Link:</strong> Entire hero area links to your destination</li>
                            <li><strong>Option:</strong> SVG Overlay</li>
                        </ul>
                        ',
                ],
            ],
        ]);
    }
}
