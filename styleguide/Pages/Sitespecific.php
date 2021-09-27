<?php

namespace Styleguide\Pages;

class Sitespecific extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'ChildpageController',
                'title' => 'Creating site specific templates',
                'id' => 99901,
                'content' => [
                    'main' => '<p>Feature names should be singular and CamelCased.</p>
                    <h2>Example new features</h2>
                    <ul><li>"Spotlight" <pre>php artisan base:feature Spotlight</pre></li>
                    <li>"Faculty Books" <pre>php artisan base:feature FacultyBook</pre></li></ul>
                    <p>'.$this->faker->paragraph(8).'</p>
                    <p>'.$this->faker->paragraph(8).'</p>',
                ],
            ],

            
        ]);
    }
}
