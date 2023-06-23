<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class PromoGrid4 extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'PromoPageController',
                'title' => 'Promotion grid, 4 columns',
                'id' => 101110500,
                'content' => [
                    'main' => '
                        <p>Use this template to display a grid of promotion items.</p>
                        <ul class="accordion mt-4">
                            <li>
                                <a href="#definition-page-setup" id="definition-page-setup"><span aria-hidden="true"></span>Page setup</a>
                                <div class="content">
                                    <ul>
                                        <li>Select template "Promo Page."</li>
                                        <li>Select Custom page field <code class="bg-gray-200 py-1 px-2 rounded text-sm">promoPage</code>.</li>
                                        <li>Paste this JSON array into the page field and edit the values to set options:<br />
<pre class="bg-gray-200 py-2 px-2 my-2 rounded text-sm inline-block">
{
"id":00000,
"config":"randomize|limit:60|page_id",
"columns":3,
"singlePromoView":"true",
"showExcerpt":"false",
"showDescription":"true",
}
</pre></li>
                                        <li><strong>ID:</strong> Required promo group ID, you do not need to set config, singlePromoView, or columns.</li>
                                        <li><strong>Config:</strong> Promo group config passed to the API, pipe delimited. Page ID is programatically assigned if \'page_id\' is used.</li>
                                        <li><strong>Columns:</strong> 2, 3, or 4; if not set, default is 1.</li>
                                        <li><strong>Single promo view:</strong> true/false; create a CMS page titled "Promo view", with the url "view".</li>
                                    </ul>
                                </div>
                            </li>
                            <li>
                                <a href="#definition-promo-setup" id="definition-promo-setup"><span aria-hidden="true"></span>Promo group setup</a>
                                <div class="content">
                                    <ul class="mb-4">
                                        <li><strong>Title</strong></li>
                                        <li><strong>Link:</strong> optional, if not using individual view</li>
                                        <li><strong>Excerpt:</strong> optional, displays underneath title</li>
                                        <li><strong>Description:</strong> optional, displays underneath excerpt</li>
                                        <li><strong>Filename:</strong> optional, 600x450px or 450x600px recommended.</li>
                                        <li><strong>Option:</strong> If options are set, promos will grouped by option. Any items without an option are grouped together at the bottom.</li>
                                    </ul>
                                </div>
                            </li>
                        </ul>
                    ',
                ],
            ],
            'data' => [
                'options' => 'true',
                'promoPage' => '{
"id":10378,
"config":"randomize|limit:20|page_id",
"columns":4,
"singlePromoView":"true",
"showExcerpt":"true",
"showDescription":"true",
}',
            ],
        ]);
    }
}
