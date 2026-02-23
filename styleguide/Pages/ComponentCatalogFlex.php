<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ComponentCatalogFlex extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ComponentCatalogFlexController',
                'title' => 'CatalogFlex',
                'id' => 125100,
                'content' => [
                    'main' => '<p>CatalogFlex promos.</p>',
                ],
            ],
        ]);
    }
}
