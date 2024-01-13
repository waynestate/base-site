<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class Fullwidth extends Page
{
    /** {@inheritdoc} **/
    public $path = '/styleguide/fullwidth';

    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'FullWidthController',
                'title' => 'Custom full-width template',
                'id' => 101109,
                'content' => [
                    'main' => '<p>This is an example of a custom full-width template and is not selectable in the CMS.</p><p>'.$this->faker->paragraph(8).'</p>
                    <p>'.$this->faker->paragraph(8).'</p>
                    <p>'.$this->faker->paragraph(8).'</p>',
                ],
            ],
        ]);
    }
}
