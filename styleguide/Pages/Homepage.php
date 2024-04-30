<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class Homepage extends Page
{
    /** {@inheritdoc} **/
    public $path = '/styleguide/homepage';

    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'HomepageController',
                'title' => 'Homepage',
                'id' => 101101,
                'content' => [
                    'main' => '<p>'.$this->faker->paragraph(8).'</p>',
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
