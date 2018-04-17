<?php

namespace Styleguide\Pages;

class ImageButtonList extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, [
            'page' => [
                'controller' => 'ImageButtonListController',
                'title' => 'Image Button List',
                'id' => 108100,
            ],
        ]);
    }
}
