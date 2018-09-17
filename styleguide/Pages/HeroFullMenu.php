<?php

namespace Styleguide\Pages;

class HeroFullMenu extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'HeroFullMenuController',
                'title' => 'Full width (menu)',
                'id' => 3,
            ],
        ]);
    }
}
