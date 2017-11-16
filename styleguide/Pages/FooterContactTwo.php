<?php

namespace Styleguide\Pages;

class FooterContactTwo extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, [
            'page' => [
                'controller' => 'FooterContactTwoController',
                'title' => 'Footer Contact Two Column',
                'id' => 104100101,
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
