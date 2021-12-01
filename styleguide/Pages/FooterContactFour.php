<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class FooterContactFour extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'FooterContactFourController',
                'title' => 'Four column',
                'id' => 104100103,
                'content' => [
                    'main' => '<p>You can have up to four columns in your contact footer.</p>',
                ],
            ],
        ]);
    }
}
