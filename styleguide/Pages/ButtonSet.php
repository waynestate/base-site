<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ButtonSet extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ButtonSetController',
                'title' => 'Button set',
                'id' => 114100,
                'content' => [
                    'main' => '<p>This component can be used as buttons under the side menu and as buttons on your page.</p>',
                ],
            ],
        ]);
    }
}
