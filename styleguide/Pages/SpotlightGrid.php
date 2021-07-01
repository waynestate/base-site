<?php

namespace Styleguide\Pages;

class SpotlightGrid extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'SpotlightGridController',
                'title' => 'Spotlight grid',
                'id' => 101115,
                'content' => [
                    'main' => '
                        <p>Display a grid of promo items that link to an individual item detail view.</p>
                        <p>Custom page field required <code class="bg-grey-lighter py-1 px-2 rounded text-sm">spotlight_promo_group_id</code>.</p>
                        <h2>Promo group setup</h2>
                        <ul class="mb-4">
                        <li><strong>Title:</strong> also the heading of the individual view</li>
                        <li><strong>Excerpt:</strong> displays underneath title in the listing and individual view</li>
                        <li><strong>Description:</strong> displays when you click through to view the item</li>
                        <li><strong>Image</strong></li>
                        </ul>
                    ',
                ],
            ],
        ]);
    }
}
