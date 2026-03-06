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
                'title' => 'Catalog Flex',
                'id' => 126100,
                'content' => [
                    'main' => '',
                ],
            ],
        ]);
    }
}
