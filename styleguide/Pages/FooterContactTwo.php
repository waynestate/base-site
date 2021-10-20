<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class FooterContactTwo extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'FooterContactTwoController',
                'title' => 'Two column',
                'id' => 104100101,
            ],
        ]);
    }
}
