<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ButtonsContent extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ButtonsController',
                'title' => 'Buttons',
                'id' => 100400,
                'content' => [
                    'main' => '<p>'.$this->faker->paragraph(8).'</p>
                    <p>'.$this->faker->paragraph(8).'</p>
                    <p>'.$this->faker->paragraph(8).'</p>',
                ],
            ],
        ]);
    }
}
