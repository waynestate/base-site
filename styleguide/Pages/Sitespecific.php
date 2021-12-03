<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class Sitespecific extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ChildpageController',
                'title' => 'Creating site specific templates',
                'id' => 99901,
                'content' => [
                    'main' => '<p>Feature names should be singular and CamelCased.</p>
                    <h2>Example new features</h2>
                    <ul><li>"Spotlight" <code class="bg-gray-200 py-1 px-2 rounded text-sm">php artisan base:feature Spotlight</code></li>
                    <li>"Faculty Books" <code class="bg-gray-200 py-1 px-2 rounded text-sm">php artisan base:feature FacultyBook</code></li></ul>
                    <p>'.$this->faker->paragraph(8).'</p>
                    <p>'.$this->faker->paragraph(8).'</p>',
                ],
            ],


        ]);
    }
}
