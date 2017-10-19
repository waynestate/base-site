<?php

namespace Styleguide\Pages;

class NotInMenu extends Page
{
    /** {@inheritdoc} **/
    public $path = '/styleguide/not/in/menu';

    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, [
            'page' => [
                'controller' => 'ChildpageController',
                'title' => 'Not In Menu',
                'id' => null,
                'content' => [
                    'main' => '<p>'.$this->faker->paragraph(8).'</p>
                    <p>'.$this->faker->paragraph(8).'</p>
                    <p>'.$this->faker->paragraph(8).'</p>',
                ],
            ],
            'menu' => [
                'id' => 1,
            ],
        ]);
    }
}
