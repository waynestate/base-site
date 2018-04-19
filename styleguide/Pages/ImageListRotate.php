<?php

namespace Styleguide\Pages;

class ImageListRotate extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, [
            'page' => [
                'controller' => 'ImageListRotateController',
                'title' => 'Image List Rotate',
                'id' => 109100,
            ],
        ]);
    }
}
