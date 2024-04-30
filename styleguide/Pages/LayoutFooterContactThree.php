<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class LayoutFooterContactThree extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'LayoutFooterContactThreeController',
                'title' => 'Three column',
                'id' => 104100102,
                'content' => [
                    'main' => '<p>You can have up to four columns in your contact footer.</p>',
                ],
            ],
        ]);
    }
}
