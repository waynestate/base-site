<?php

namespace Styleguide\Pages;

class ContactTablesNoTOC extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'data' => [
                'profile_group_id' => '0|1|2|3',
                'table_of_contents' => 'hide',
            ],
            'page' => [
                'controller' => 'ContactTableController',
                'title' => 'Contact tables, no table of contents',
                'id' => 101114,
                'content' => [],
            ],
        ]);
    }
}
