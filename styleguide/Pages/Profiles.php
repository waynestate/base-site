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
                'title' => 'Profile listing',
                'id' => 101103,
            ],
        ]);
    }
}
