<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ComponentCatalogGrouped extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ComponentCatalogController',
                'title' => 'Catalog - Grouped by option',
                'id' => 118100500,
                'content' => [
                    'main' => '<p>The grouped-by-option catalog component is ideal for showcasing a collection of items from a single promo group, organized by their dropdown option, in a multiple-column grid format.</p>',
                ],
            ],
        ]);
    }
}
