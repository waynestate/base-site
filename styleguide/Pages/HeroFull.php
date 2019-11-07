<?php

namespace Styleguide\Pages;

class HeroFull extends Page
{
    /** {@inheritdoc} **/
    public $path = '/styleguide/hero/full';

    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'HeroFullController',
                'title' => 'Full width',
                'id' => 105100103,
            ],
        ]);
    }
}
