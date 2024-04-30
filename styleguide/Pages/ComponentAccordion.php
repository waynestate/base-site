<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ComponentAccordion extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ComponentAccordionController',
                'title' => 'Accordion',
                'id' => 107100,
                'content' => [
                    'main' => '',
                ],
            ],
        ]);
    }
}
