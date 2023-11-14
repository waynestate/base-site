<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class HeroFullRotate extends Page
{
    /** {@inheritdoc} **/
    public $path = '/styleguide/hero/full';

    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'HeroRotateController',
                'title' => 'Rotate',
                'id' => 105100104,
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
