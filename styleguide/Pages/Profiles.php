<?php

namespace Styleguide\Pages;

class Profiles extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, [
            'page' => [
                'controller' => 'ProfileController',
                'title' => 'Profile Listing',
                'id' => 101103,
                'content' => [
                    'main' => '',
                ],
            ],
            'menu' => [
                'id' => 1,
            ],
            'site' => [
                'subsite-folder' => 'styleguide/',
            ],
        ]);
    }
}
