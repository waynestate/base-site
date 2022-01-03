<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class MenuTop extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'MenuTopController',
                'title' => 'Menu top',
                'id' => 103100101,
            ],
        ]);
    }
}
