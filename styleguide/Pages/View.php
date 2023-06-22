<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class View extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'PromoListingController',
                'title' => 'Promo view',
                'id' => 101110300,
                'content' => [
                    'main' => '
                        <h2>Page setup</h2>
                        <ul>
                            <li>Create a CMS page titled "Promo view", with the url "view".</li>
                            <li>Select template "Promo Page."</li>
                            <li>Add it to the menu for breadcrumbs to display.</li>
                        </ul>
                    ',
                ],
            ],
        ]);
    }
}
