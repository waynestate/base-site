<?php

namespace Styleguide\Pages;

class FooterContactThree extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, [
            'page' => [
                'controller' => 'FooterContactThreeController',
                'title' => 'Footer Contact Three Column',
                'id' => 104100102,
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
