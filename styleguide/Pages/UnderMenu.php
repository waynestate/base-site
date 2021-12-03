<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class UnderMenu extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'UnderMenuController',
                'title' => 'Under menu',
                'id' => 114100,
            ],
        ]);
    }
}
