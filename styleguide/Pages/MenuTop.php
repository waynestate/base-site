<?php

namespace Styleguide\Pages;

class MenuTop extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, [
            'page' => [
                'controller' => 'MenuTopController',
                'title' => 'Menu Top',
                'id' => 103100101,
            ],
        ]);
    }
}
