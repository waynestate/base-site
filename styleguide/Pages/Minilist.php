<?php

namespace Styleguide\Pages;

class Minilist extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, [
            'page' => [
                'controller' => 'MiniListController',
                'title' => 'Mini List',
                'id' => 112100,
                'content' => [],
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
