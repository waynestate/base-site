<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class ComponentListservSubscribe extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'ComponentListservSubscribeController',
                'title' => 'Listserv subscribe',
                'id' => 120100,
                'content' => [
                    'main' => '<p>Mailing list subscribe form posting directly to the WSU Formy subscriptions service. The form action and hidden list field both use the configured list identifier, and an optional promotion group provides the form heading, description, and image.</p>',
                ],
            ],
        ]);
    }
}
