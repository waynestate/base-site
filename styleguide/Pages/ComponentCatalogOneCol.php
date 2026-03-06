<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ComponentCatalogOneCol extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ComponentCatalogController',
                'title' => 'Catalog - One column',
                'id' => 118100100,
                'content' => [
                    'main' => '<p>The one-column catalog component is ideal for showcasing a collection of items from a single promo group in a single-column list format.</p>',
                ],
            ],
        ]);
    }
}
