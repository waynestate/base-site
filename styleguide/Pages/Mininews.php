<?php

namespace Styleguide\Pages;

class Mininews extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, [
            'page' => [
                'controller' => 'MiniNewsController',
                'title' => 'Mini News',
                'id' => 109100,
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
