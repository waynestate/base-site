<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class LayoutMain extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'LayoutController',
                'title' => 'Main layout',
                'id' => 120100100,
            ],
        ]);
    }
}
