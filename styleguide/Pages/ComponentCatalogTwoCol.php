<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ComponentCatalogTwoCol extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ComponentCatalogController',
                'title' => 'Catalog',
                'id' => 118100200,
                'content' => [
                    'main' => '',
                ],
            ],
        ]);
    }
}
