<?php

namespace Styleguide\Pages;

class ContactTables extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'data' => [
                'profile_group_id' => '0|1|2|3',
            ],
            'page' => [
                'controller' => 'ContactTableController',
                'title' => 'Contact tables',
                'id' => 101113,
                'content' => [],
            ],
        ]);
    }
}
