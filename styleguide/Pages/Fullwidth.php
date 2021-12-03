<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class Fullwidth extends Page
{
    /** {@inheritdoc} **/
    public $path = '/styleguide/fullwidth';

    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'FullWidthController',
                'title' => 'Full width',
                'id' => 101109,
            ],
        ]);
    }
}
