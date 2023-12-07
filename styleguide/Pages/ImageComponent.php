<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ImageComponent extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ImageController',
                'title' => 'Image',
                'id' => 120100,
                'content' => [
                    'main' => '<p>Single image with a title and gradient overlay.</p>',
                ],
            ],
        ]);
    }
}
