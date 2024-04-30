<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class LayoutNoMenu extends Page
{
    /** {@inheritdoc} **/
    public $path = '/styleguide/layout/nomenu';

    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ChildpageController',
                'title' => 'No menu',
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
