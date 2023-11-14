<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class HeroFullLogoOverlay extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'HeroLogoController',
                'title' => 'Logo overlay',
                'id' => 105100107,
                'content' => [
                    'main' => '
                        <h2>Promo group setup</h2>
                        <p>Only available for full-width templates</p>
                        <ul>
                            <li><strong>Primary image:</strong> Background image</li>
                            <li><strong>Secondary image:</strong> Your logo as PNG or SVG</li>
                            <li><strong>Title:</strong> Brief title </li>
                            <li><strong>Description:</strong> Text will be centered, buttons allowed</li>
                            <li><strong>Option:</strong> Logo Overlay</li>
                        </ul>
                        ',
                ],
            ],
        ]);
    }
}
