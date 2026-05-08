<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class LayoutCustom extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'LayoutController',
                'title' => 'Custom layout',
                'id' => 120100100,
            ],
        ]);
    }
}
