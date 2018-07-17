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
                'title' => 'Contained (rotate with text)',
                'id' => 105100102,
            ],
        ]);
    }
}
