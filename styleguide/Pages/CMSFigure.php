<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class CMSFigure extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'CMSFigureController',
                'title' => 'Figure',
                'id' => 115100,
            ],
        ]);
    }
}
