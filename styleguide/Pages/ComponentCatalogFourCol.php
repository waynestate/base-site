<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ComponentCatalogFourCol extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ComponentCatalogController',
                'title' => 'Catalog - Four column',
                'id' => 118100400,
                'content' => [
                    'main' => '<p>The four-column catalog component is ideal for showcasing a collection of items from a single promo group in a multiple-column grid format.</p>',
                ],
            ],
        ]);
    }
}
