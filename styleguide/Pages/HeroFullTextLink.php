<?php

namespace Styleguide\Pages;

class HeroFullTextLink extends Page
{
    /** {@inheritdoc} **/
    public $path = '/styleguide/hero/full/text/link';

    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'HeroFullTextLinkController',
                'title' => 'Full width (text/link)',
                'id' => 105100107,
            ],
        ]);
    }
}
