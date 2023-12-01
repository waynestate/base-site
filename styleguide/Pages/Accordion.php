<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class Accordion extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'AccordionController',
                'title' => 'Accordion',
                'id' => 107100,
                'content' => [
                    'main' => '<p>You can now add more than one accordion to a page.</p>',
                ],
            ],
        ]);
    }
}
