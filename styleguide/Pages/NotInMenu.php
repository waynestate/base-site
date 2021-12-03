<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class NotInMenu extends Page
{
    /** {@inheritdoc} **/
    public $path = '/styleguide/not/in/menu';

    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ChildpageController',
                'title' => 'Not in menu',
                'id' => null,
                'content' => [
                    'main' => '<p>'.$this->faker->paragraph(8).'</p>
                    <p>'.$this->faker->paragraph(8).'</p>
                    <p>'.$this->faker->paragraph(8).'</p>',
                ],
            ],
        ]);
    }
}
