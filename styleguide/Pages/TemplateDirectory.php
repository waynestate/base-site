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
        return app(PageFactory::class)->create(1, true, [
            'site' => [
                'people' => [
                    'site_id' => 1,
                ],
            ],
            'page' => [
                'controller' => 'DirectoryController',
                'title' => 'Directory',
                'id' => 101107,
            ],
        ]);
    }
}
