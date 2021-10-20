<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class Tablesortable extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'TableSortableController',
                'title' => 'Table sortable',
                'id' => 113101,
            ],
        ]);
    }
}
