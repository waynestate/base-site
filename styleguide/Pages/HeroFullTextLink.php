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
        return app('Factories\Page')->create(1, [
            'page' => [
                'controller' => 'HeroFullTextLinkController',
                'title' => 'Hero Full (Text/Link)',
                'id' => 105100107,
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
