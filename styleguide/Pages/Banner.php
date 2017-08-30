<?php

namespace Styleguide\Pages;

class Banner extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, [
            'page' => [
                'controller' => 'BannerController',
                'title' => 'Banner',
                'id' => 114100,
                'content' => [],
            ],
            'menu' => [
                'id' => 1,
            ],
        ]);
    }
}
