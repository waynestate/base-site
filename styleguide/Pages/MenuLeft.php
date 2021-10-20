<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class MenuLeft extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'MenuLeftController',
                'title' => 'Menu left',
                'id' => 103100100,
            ],
        ]);
    }
}
