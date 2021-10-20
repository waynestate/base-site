<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class Error500 extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'Error500Controller',
                'title' => '500 page',
                'id' => 106100102,
            ],
        ]);
    }
}
