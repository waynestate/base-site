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
                'id' => 108100,
            ],
        ]);
    }
}
