<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class Error extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ChildpageController',
                'title' => 'Error pages',
                'id' => 106100,
            ],
        ]);
    }
}
