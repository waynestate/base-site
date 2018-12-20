<?php

namespace Styleguide\Pages;

class FormsError extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'FormsErrorController',
                'title' => 'Form Errors',
                'id' => 111100100,
            ],
        ]);
    }
}
