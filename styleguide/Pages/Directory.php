<?php

namespace Styleguide\Pages;

class Directory extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, [
            'page' => [
                'controller' => 'DirectoryController',
                'title' => 'Directory',
                'id' => 101104,
                'content' => [
                    'main' => '',
                ],
            ],
            'menu' => [
                'id' => 1,
            ],
            'site' => [
                'subsite-folder' => 'styleguide/',
            ],
        ]);
    }
}
