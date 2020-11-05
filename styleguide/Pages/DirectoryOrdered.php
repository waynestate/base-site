<?php

namespace Styleguide\Pages;

class DirectoryOrdered extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'DirectoryController',
                'title' => 'Directory ordered',
                'id' => 101112,
            ],
            'data' => [
                'profile_group_id' => '0|1',
            ],
        ]);
    }
}
