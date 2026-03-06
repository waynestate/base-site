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
                'title' => 'Catalog - Two column',
                'id' => 118100200,
                'content' => [
                    'main' => '<p>The two-column catalog component is ideal for showcasing a collection of items from a single promo group in a multiple-column grid format.</p>',
                ],
            ],
        ]);
    }
}
