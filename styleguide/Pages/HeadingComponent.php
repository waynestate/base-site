<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class HeadingComponent extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'HeadingComponentController',
                'title' => 'Heading',
                'id' => 122100,
                'content' => [
                    'main' => '',
                ],
            ],
        ]);
    }
}
