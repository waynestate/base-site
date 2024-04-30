<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class Error404 extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'Error404Controller',
                'title' => '404 page',
                'id' => 106100101,
            ],
        ]);
    }
}
