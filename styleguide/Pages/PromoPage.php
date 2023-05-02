<?php

namespace Styleguide\Pages;

use Factories\Page as PageFactory;

class PromoPage extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app(PageFactory::class)->create(1, true, [
            'page' => [
                'controller' => 'PromoPageController',
                'title' => 'Promo page',
                'id' => 101110400,
                'content' => [
                    'main' => '
                        <h2>Page setup</h2>
                        <ul>
                            <li>Select template "Promo Page."</li>
                            <li>Select Custom page field <code class="bg-gray-200 py-1 px-2 rounded text-sm">promoPage</code>.</li>
                            <li>Paste this JSON array into the page field and edit the values to set options:<br />
<pre class="bg-gray-200 py-2 px-2 my-2 rounded text-sm inline-block">
{
"id":10378,
"config":"randomize|limit:20|page_id",
"columns":4,
"singlePromoView":"true",
"showExcerpt":"true",
"showDescription":"true",
}
</pre></li>
                            <li><strong>ID:</strong> Required promo group ID, you do not need to set config, singlePromoView, or columns.</li>
                            <li><strong>Config:</strong> Promo group config passed to the API, pipe delimited. Page ID is programatically assigned if \'page_id\' is used.</li>
                            <li><strong>Columns:</strong> 2, 3, or 4; if not set, default is 1.</li>
                            <li><strong>Single promo view:</strong> true/false; create a CMS page titled "Promo view", with the url "view".</li>
                        </ul>
                        <h2>Promo group setup</h2>
                        <ul class="mb-4">
                            <li><strong>Title</strong></li>
                            <li><strong>Link:</strong> optional, if not using individual view</li>
                            <li><strong>Excerpt:</strong> optional, displays underneath title</li>
                            <li><strong>Description:</strong> optional, displays underneath excerpt</li>
                            <li><strong>Filename:</strong> optional, 600x450px or 450x600px recommended.</li>
                            <li><strong>Option:</strong> If options are set, promos will grouped by option. Any items without an option are grouped together at the bottom.</li>
                        </ul>
                    ',
                ],
            ],
            'data' => [
                'listing_promo_group_id' => 12345,
                'options' => 'true',
            ],
        ]);
    }
}
