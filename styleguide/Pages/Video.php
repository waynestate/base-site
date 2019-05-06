<?php

namespace Styleguide\Pages;

class Video extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'VideoController',
                'title' => 'Video',
                'id' => 117100,
            ],
        ]);
    }
}
