<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class Profiles extends Page
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
                'controller' => 'ProfileController',
                'title' => 'Profile listing',
                'id' => 101105,
            ],
        ]);
    }
}
