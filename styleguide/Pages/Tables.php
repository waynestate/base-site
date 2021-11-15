<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class Tables extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'TablesController',
                'title' => 'Tables',
                'id' => 113100,
            ],
        ]);
    }
}
