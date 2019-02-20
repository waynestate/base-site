<?php

namespace Styleguide\Pages;

class Grid extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'GridController',
                'title' => 'Grid',
                'id' => 101106,
                'content' => [
                    'main' => '<p>'.$this->faker->paragraph(8).'</p>
                    <p>'.$this->faker->paragraph(8).'</p>',
                ],
            ],
        ]);
    }
}
