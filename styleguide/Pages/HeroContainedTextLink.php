<?php

namespace Styleguide\Pages;

class HeroContainedTextLink extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, [
            'page' => [
                'controller' => 'HeroContainedTextLinkController',
                'title' => 'Contained (With Text/Link)',
                'id' => 105100103,
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
