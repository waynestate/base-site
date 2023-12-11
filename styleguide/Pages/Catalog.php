<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class Catalog extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'CatalogController',
                'title' => 'Catalog',
                'id' => 118100,
                'content' => [], // On controller
            ],
        ]);
    }
}
