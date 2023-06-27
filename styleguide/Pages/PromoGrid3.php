<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class PromoGrid3 extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'PromoPageController',
                'title' => 'Promotion grid, 3 columns',
                'id' => 101110400,
                'content' => [
                    'main' => '
                        <p>Use this template to display a list of promotion items grouped by their dropdown option.</p>
                        <ul class="accordion mt-4">
                            <li>
                                <a href="#definition-page-setup" id="definition-page-setup"><span aria-hidden="true"></span>Page setup</a>
                                <div class="content">
                                    <ul>
                                        <li>Select template "Promo Page."</li>
                                        <li>Select Custom page field <code>promoPage</code>.</li>
                                        <li>Paste this JSON array into the page field and edit the values to set options:<br />
<pre>
{
"id":00000,
"config":"randomize|limit:60|page_id",
"columns":3,
"singlePromoView":"true",
"showExcerpt":"false",
"showDescription":"true",
}
</pre>
                                            <table class="mt-2">
                                                <tr>
                                                    <th colspan="2">Configuration settings</th>
                                                </tr>
                                                <tr>
                                                    <td class="font-bold">id</td>
                                                    <td>Promo group ID. Required.</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-bold">config</td>
                                                    <td>Promo group config, pipe delimited. Use \'page_id\' for per-page items. Optional.</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-bold">columns</td>
                                                    <td>2, 3, or 4. Default/unset is 1, a list. Optional.</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-bold">singlePromoview</td>
                                                    <td>True or false. False(default) will enable the promotion\'s link field. Optional.</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-bold">showExcerpt</td>
                                                    <td>True or false. True is default. Optional.</td>
                                                </tr>
                                                <tr>
                                                    <td class="font-bold">showDescription</td>
                                                    <td>True or false. True is default. Optional.</td>
                                                </tr>
                                            </table>
                                        </li>
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
                                            <td>Promo title. Will turn into a link if link field is used or single promo view is set.</td>
                                        </tr>
                                        <tr>
                                            <td class="font-bold">Link</td>
                                            <td>External link. Do not set if using individual promo view.</td>
                                        </tr>
                                        <tr>
                                            <td class="font-bold">Excerpt</td>
                                            <td>Single line of unformatted text, like a job title.</td>
                                        </tr>
                                        <tr>
                                            <td class="font-bold">Description</td>
                                            <td>Formattable text. Main body content for single promo view.</td>
                                        </tr>
                                        <tr>
                                            <td class="font-bold">Filename</td>
                                            <td>600x450px, or minimum width 600px any height.</td>
                                        </tr>
                                        <tr>
                                            <td class="font-bold">Option</td>
                                            <td>If options are set, promos will be grouped by their option automatically. Any items without an option are grouped together at the bottom.</td>
                                        </tr>
                                    </table>
                                </div>
                            </li>
                        </ul>
                    ',
                ],
            ],
            'data' => [
                'listing_promo_group_id' => 12345,
                'options' => 'true',
                'promoPage' => '{
"id":10378,
"config":"randomize|limit:20|page_id",
"columns":3,
"singlePromoView":"true",
"showExcerpt":"false",
"showDescription":"true",
}',
            ],
        ]);
    }
}
