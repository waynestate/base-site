<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class HeroLogoOverlay extends Page
{
    /** {@inheritdoc} **/
    public $path = '/styleguide/hero/logooverlay';

    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'HeroController',
                'title' => 'Hero logo overlay',
                'id' => 105100107,
                'content' => [
                    'main' => '',
                ],
            ],
        ]);
    }
}
