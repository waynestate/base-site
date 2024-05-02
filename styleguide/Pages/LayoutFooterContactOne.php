<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class LayoutFooterContactOne extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'LayoutFooterContactOneController',
                'title' => 'One column',
                'id' => 104100100,
                'content' => [
                    'main' => '<p>You can have up to four columns in your contact footer.</p>',
                ],
            ],
        ]);
    }
}
