<?php

namespace Styleguide\Pages;

class Profile extends Page
{
    /** {@inheritdoc} **/
    public $path = '/styleguide/profile/aa0000';

    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, [
            'page' => [
                'controller' => 'ProfileController',
                'title' => 'Profile View',
                'id' => null,
                'content' => [
                    'main' => '',
                ],
            ],
            'menu' => [
                'id' => 1,
            ],
        ]);
    }
}
