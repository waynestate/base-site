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
                'title' => 'Full width template',
                'id' => 101109,
                'content' => [
                    'main' => '<p>'.$this->faker->paragraph(8).'</p>'
                ],
            ],
            'site' => [
                'subsite-folder' => 'styleguide/',
                'news' => [
                    'application_id' => 1,
                ],
                'events' => [
                    'path' => 'main'
                ],
            ],
        ]);
    }
}
