<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ComponentHeading extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ComponentHeadingController',
                'title' => 'Heading',
                'id' => 122100,
                'content' => [
                    'main' => '',
                ],
            ],
        ]);
    }
}
