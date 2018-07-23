<?php

namespace Styleguide\Pages;

class HeroContainedTextLink extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'HeroContainedTextLinkController',
                'title' => 'Contained (with text/link)',
                'id' => 105100103,
            ],
        ]);
    }
}
