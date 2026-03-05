<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ComponentCatalogThreeCol extends Page
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
                'id' => 118100300,
                'content' => [
                    'main' => '',
                ],
            ],
        ]);
    }
}
