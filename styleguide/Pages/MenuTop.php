<?php

namespace Styleguide\Pages;

class MenuTop extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'MenuTopController',
                'title' => 'Menu top',
                'id' => 103100101,
            ],
        ]);
    }
}
