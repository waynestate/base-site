<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class Flag extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'FlagController',
                'title' => 'Flag',
                'id' => 112100,
            ],
        ]);
    }
}
