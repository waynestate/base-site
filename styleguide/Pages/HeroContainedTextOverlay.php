<?php

namespace Styleguide\Pages;

class HeroContainedTextOverlay extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'HeroContainedTextOverlayController',
                'title' => 'Contained - Text overlay',
                'id' => 105100102,
                'content' => [
                    'main' => '
                        <h2>Promo group setup</h2>
                        <ul>
                            <li><strong>Primary image:</strong> Background image</li>
                            <li><strong>Title:</strong> Brief title </li>
                            <li><strong>Description:</strong> Paragraph text with inline links</li>
                            <li><strong>Option:</strong> Text Overlay</li>
                        </ul>
                        ',
                ],
            ],
        ]);
    }
}
