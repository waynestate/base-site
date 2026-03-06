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
                'title' => 'Catalog - Three column',
                'id' => 118100300,
                'content' => [
                    'main' => '<p>The three-column catalog component is ideal for showcasing a collection of items from a single promo group in a multiple-column grid format.</p>',
                ],
            ],
        ]);
    }
}
