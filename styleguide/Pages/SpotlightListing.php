<?php

namespace Styleguide\Pages;

class SpotlightListing extends Page
{
    /**
     * {@inheritdoc}
     */
    public function getPageData()
    {
        return app('Factories\Page')->create(1, true, [
            'page' => [
                'controller' => 'SpotlightController',
                'title' => 'Spotlight listing',
                'id' => 101111,
                'content' => [
                    'main' => '
                        <h2>Page setup</h2>
                        <p>Custom page field required <code class="bg-grey-lighter py-1 px-2 rounded text-sm">spotlight_promo_group_id</code></p>
                        <h2>Promo group setup</h2>
                        <ul class="mb-4">
                        <li><strong>Title:</strong> also the heading of the individual view</li>
                        <li><strong>Excerpt:</strong> displays underneath title</li>
                        <li><strong>Description:</strong> displays when you click through to view the item</li>
                        <li><strong>Filename:</strong> image can be any size as long as it\'s consistent</li>
                        </ul>
                    ',
                ],
            ],
        ]);
    }
}
