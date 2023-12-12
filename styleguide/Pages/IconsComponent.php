<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class IconsComponent extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'IconsController',
                'title' => 'Icons',
                'id' => 121100,
                'content' => [
                    'main' => '',
                ],
            ],
        ]);
    }
}
