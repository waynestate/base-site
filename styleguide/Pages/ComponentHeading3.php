<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ComponentHeading3 extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ComponentHeadingController',
                'title' => 'H3',
                'id' => 122100200,
                'content' => [
                    'main' => '',
                ],
            ],
        ]);
    }
}
