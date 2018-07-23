<?php

namespace Styleguide\Pages;

class ImageListRotate extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'ImageListRotateController',
                'title' => 'Image list rotate',
                'id' => 109100,
            ],
        ]);
    }
}
