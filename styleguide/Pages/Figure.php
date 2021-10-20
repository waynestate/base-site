<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class Figure extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'FigureController',
                'title' => 'Figure',
                'id' => 115100,
            ],
        ]);
    }
}
