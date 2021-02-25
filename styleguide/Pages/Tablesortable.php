<?php

namespace Styleguide\Pages;

class Tablesortable extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'TableSortableController',
                'title' => 'Table sortable',
                'id' => 113101,
            ],
        ]);
    }
}
