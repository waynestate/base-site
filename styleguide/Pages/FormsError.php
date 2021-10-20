<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class FormsError extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'FormsErrorController',
                'title' => 'Form Errors',
                'id' => 111100100,
            ],
        ]);
    }
}
