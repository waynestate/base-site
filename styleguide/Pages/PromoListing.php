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
                'id' => 101116,
                'content' => [
                    'main' => '
                        <h2>Page setup</h2>
                        <p>Custom page field required <code class="bg-grey-lighter py-1 px-2 rounded text-sm">listing_promo_group_id</code>.</p>
                        <h2>Promo group setup</h2>
                        <ul class="mb-4">
                        <li><strong>Title</strong></li>
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
