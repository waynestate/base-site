<?php

namespace Styleguide\Pages;

class Mininews extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'MiniNewsController',
                'title' => 'Mini news',
                'id' => 108100,
            ],
            'site' => [
                'subsite-folder' => 'styleguide/',
            ],
        ]);
    }
}
