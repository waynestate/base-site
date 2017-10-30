<?php

namespace Styleguide\Pages;

class NoMenu extends Page
{
    /** {@inheritdoc} **/
    public $path = '/styleguide/no/menu';

    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, [
            'page' => [
                'controller' => 'ChildpageController',
                'title' => 'No Menu',
                'id' => null,
                'content' => [
                    'main' => '<p>'.$this->faker->paragraph(8).'</p>
                    <p>'.$this->faker->paragraph(8).'</p>
                    <p>'.$this->faker->paragraph(8).'</p>',
                ],
            ],
            'menu' => [
                'id' => null,
            ],
        ]);
    }
}
