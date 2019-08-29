<?php

namespace Styleguide\Pages;

class Profile extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'ProfileController',
                'title' => 'Profile view',
                'id' => 101106,
            ],
        ]);
    }
}
