<?php

namespace Styleguide\Pages;

class HeroFullLogoOverlay extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'HeroFullLogoOverlayController',
                'title' => 'Full width - Logo overlay',
                'id' => 105100107,
                'content' => [
                    'main' => '
                        <h2>Promo group setup</h2>
                        <ul>
                            <li><strong>Primary image:</strong> Background image</li>
                            <li><strong>Secondary image:</strong> Your logo as PNG or SVG. Can be any size. It appears above title and description</li>
                            <li><strong>Description:</strong> Text will be centered, buttons allowed</li>
                        </ul>
                        ',
                ],
            ],
        ]);
    }
}
