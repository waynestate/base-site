<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class Colors extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ColorsController',
                'title' => 'Colors',
                'id' => 100800,
            ],
        ]);
    }
}
