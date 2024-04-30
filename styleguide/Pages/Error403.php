<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class Error403 extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'Error403Controller',
                'title' => '403 page',
                'id' => 106100100,
            ],
        ]);
    }
}
