<?php

namespace Styleguide\Pages;

class Figure extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'FigureController',
                'title' => 'Figure',
                'id' => 115100,
            ],
        ]);
    }
}
