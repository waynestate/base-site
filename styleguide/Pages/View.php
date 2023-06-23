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
                        <ul class="accordion mt-4">
                            <li>
                                <a href="#definition-page-setup" id="definition-page-setup"><span aria-hidden="true"></span>Page setup</a>
                                <div class="content">
                                    <ul>
                                        <li>Create a CMS page titled "Promo view", with the url "view".</li>
                                        <li>Select template "Promo Page."</li>
                                        <li>Add it to the menu for breadcrumbs to display.</li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a href="#definition-promo-setup" id="definition-promo-setup"><span aria-hidden="true"></span>Promo group setup</a>
                                <div class="content">
                                    <ul class="mb-4">
                                        <li><strong>Title:</strong> Page title.</li>
                                        <li><strong>Link:</strong> Not shown here.</li>
                                        <li><strong>Excerpt:</strong> Displays before description, optional.</li>
                                        <li><strong>Description:</strong> Main body content.</li>
                                        <li><strong>Filename:</strong> Primary promo image, minimum 600 width x any height, optional.</li>
                                        <li><strong>Option:</strong> Not shown here.</li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    ',
                ],
            ],
        ]);
    }
}
