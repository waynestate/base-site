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
                'controller' => 'PromoPageController',
                'title' => 'Promotion view',
                'id' => 101110100,
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
                                    <table class="mt-2">
                                        <tr>
                                            <th colspan="2">Available fields</th>
                                        </tr>
                                        <tr>
                                            <td class="font-bold">Title</td>
                                            <td>Page title.</td>
                                        </tr>
                                        <tr>
                                            <td class="font-bold">Link</td>
                                            <td>Not shown here.</td>
                                        </tr>
                                        <tr>
                                            <td class="font-bold">Excerpt</td>
                                            <td>Single line of unformatted text, like a job title.</td>
                                        </tr>
                                        <tr>
                                            <td class="font-bold">Description</td>
                                            <td>Formattable text. Main body content.</td>
                                        </tr>
                                        <tr>
                                            <td class="font-bold">Filename</td>
                                            <td>Primary promo image, 600x450px, or minimum width 600px any height. Optional.</td>
                                        </tr>
                                        <tr>
                                            <td class="font-bold">Option</td>
                                            <td>Not shown here.</td>
                                        </tr>
                                    </table>
                                </div>
                            </li>
                        </ul>
                    ',
                ],
            ],
        ]);
    }
}
