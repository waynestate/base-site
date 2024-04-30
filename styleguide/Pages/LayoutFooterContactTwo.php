<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class LayoutFooterContactTwo extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'LayoutFooterContactTwoController',
                'title' => 'Two column',
                'id' => 104100101,
                'content' => [
                    'main' => '<p>You can have up to four columns in your contact footer.</p>',
                ],
            ],
        ]);
    }
}
