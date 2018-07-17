<?php

namespace Styleguide\Pages;

class Fullwidth extends Page
{
    /** {@inheritdoc} **/
    public $path = '/styleguide/fullwidth';

    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, [
            'page' => [
                'controller' => 'FullWidthController',
                'title' => 'Full width',
                'id' => 101105,
            ],
        ]);
    }
}
