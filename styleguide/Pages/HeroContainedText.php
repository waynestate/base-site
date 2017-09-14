<?php

namespace Styleguide\Pages;

class HeroContainedText extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, [
            'page' => [
                'controller' => 'HeroContainedTextController',
                'title' => 'Contained (Rotate With Text)',
                'id' => 105100102,
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
