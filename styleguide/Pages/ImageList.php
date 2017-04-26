<?php

namespace Styleguide\Pages;

class ImageList extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, [
            'page' => [
                'controller' => 'ImageListController',
                'title' => 'Image List',
                'id' => 109100,
                'content' => [],
            ],
            'menu' => [
                'id' => 1,
            ],
        ]);
    }
}
