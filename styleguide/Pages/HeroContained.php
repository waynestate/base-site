<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class HeroContained extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'HeroContainedController',
                'title' => 'Contained',
                'id' => 105100100,
                'content' => [
                    'main' => '<p>Adding a hero component above your childpage content.</p>',
                ],
            ],
        ]);
    }
}
