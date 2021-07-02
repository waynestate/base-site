<?php

namespace Styleguide\Pages;

class PromoListing extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'PromoListingController',
                'title' => 'Promo listing',
                'id' => 101110200,
                'content' => [
                    'main' => '
                        <h2>Page setup</h2>
                        <ul>
                            <li>Custom page field required <code class="bg-grey-lighter py-1 px-2 rounded text-sm">listing_promo_group_id</code>.</li>
                            <li>Enable individual item view custom page field <code class="bg-grey-lighter py-1 px-2 rounded text-sm">promotion_view_boolean</code>.</li>
                            <li>If using individual view, you need to create a CMS page titled "Promo view", with the url "view".</li>
                        </ul>
                        <h2>Promo group setup</h2>
                        <ul class="mb-4">
                        <li><strong>Title</strong></li>
                        <li><strong>Link:</strong> optional, if not using individual view</li>
                        <li><strong>Excerpt:</strong> optional, displays underneath title</li>
                        <li><strong>Description:</strong> optional, displays underneath excerpt</li>
                        <li><strong>Filename:</strong> optional, image can be any size as long as it\'s consistent</li>
                        </ul>
                    ',
                ],
            ],
        ]);
    }
}
