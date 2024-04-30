<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class LayoutMenuTop extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'LayoutMenuTopController',
                'title' => 'Menu top',
                'id' => 103100101,
            ],
        ]);
    }
}
