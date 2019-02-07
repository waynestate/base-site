<?php

namespace Styleguide\Pages;

class VideoFull extends Page
{
    /** {@inheritdoc} **/
    public $path = '/styleguide/fullwidth';

    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'VideoFullController',
                'title' => 'Video Full',
                'id' => 117100,
            ],
        ]);
    }
}
