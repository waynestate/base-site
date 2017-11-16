<?php

namespace Styleguide\Pages;

class HeroFullMenu extends Page
{
    /** {@inheritdoc} **/
    public $path = '/styleguide/hero/full/menu';

    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, [
            'page' => [
                'controller' => 'HeroFullMenuController',
                'title' => 'Hero Full (Menu)',
                'id' => 3,
                'content' => [
                    'main' => '',
                ],
            ],
            'menu' => [
                'id' => 1,
            ],
        ]);
    }
}
