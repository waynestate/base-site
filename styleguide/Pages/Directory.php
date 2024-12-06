<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class Directory extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        config(['profile.group_id' => null]);
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'DirectoryController',
                'title' => 'Directory',
                'id' => 101107,
            ],
        ]);
    }
}
