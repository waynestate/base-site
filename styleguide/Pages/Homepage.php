<?php

namespace Styleguide\Pages;

class Homepage extends Page
{
    /** {@inheritdoc} **/
    public $path = '/styleguide/homepage';

    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, [
           'page' => [
               'controller' => 'HomepageController',
               'title' => 'Homepage',
               'id' => 101101,
               'content' => [
                   'main' => '<p>'.$this->faker->paragraph(8).'</p>',
               ],
           ],
           'menu' => [
               'id' => 1,
           ],
       ]);
    }
}
