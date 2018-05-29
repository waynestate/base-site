<?php

namespace Styleguide\Pages;

class Fullwidth extends Page
{
    /** {@inheritdoc} **/
    public $path = '/styleguide/fullwidth';

    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, [
            'page' => [
                'controller' => 'FullWidthController',
                'title' => 'Full Width',
                'id' => 101105,
                'content' => [
                    'main' => '<div class="bg-grey-lighter"><div class="row p-4">'.
                        '<p>'.$this->faker->paragraph(5).'</p>'.
                        '<p>'.$this->faker->paragraph(5).'</p>'.
                        '<p>'.$this->faker->paragraph(5).'</p>'.
                    '</div></div>',
                ],
            ],
        ]);
    }
}
