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
                'title' => 'Three column',
                'id' => 104100102,
            ],
        ]);
    }
}
