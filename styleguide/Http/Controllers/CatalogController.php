<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;
use Factories\GenericPromo;
use Factories\PromoWithOptions;
use Contracts\Repositories\PromoRepositoryContract;
use Contracts\Repositories\ModularPageRepositoryContract;

class CatalogController extends Controller
{
    /**
     * Construct the controller.
     *
     */
    public function __construct(
        Factory $faker,
        PromoRepositoryContract $promo,
        ModularPageRepositoryContract $components
    ) {
        $this->promo = $promo;
        $this->components = $components;
        $this->faker['faker'] = $faker->create();
    }

    /**
     * Article Listing Controller
     */
    public function index(Request $request): View
    {
        $request->data['base']['page']['content']['main'] = '';
        $promotion_group_details = '';
        $component_configuration = '';

        $request->data['base']['page']['content']['main'] = '
<p>Display a grid or listing of items from a single promo group.</p>
';
        $component_configuration = '
<table>
    <thead>
        <tr>
            <th>Page field</th>
            <th>Data</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <pre class="w-full">modular-catalog-1</pre>
            </td>
            <td>
<pre class="w-full" tabindex="0">
{
"id":000000,
"heading":"Catalog",
"config":"randomize|limit:1|page_id|youtube",
"columns":3,
"singlePromoView":true,
"showExcerpt":true,
"showDescription":false,
"groupByOptions":false,
"gradientOverlay":false
}
</pre>
            </td>
        </tr>
    </tbody>
</table>
';
        $promotion_group_details = '
<table class="mt-2">
    <thead>
        <tr>
            <th colspan="2">Available fields</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="font-bold">Title</td>
            <td>Bold text.</td>
        </tr>
        <tr>
            <td class="font-bold">Link</td>
            <td>Optional external link. Component flag "singlePromoView" sets the link to the individual promo item view.</td>
        </tr>
        <tr>
            <td class="font-bold">Excerpt</td>
            <td>Optional smaller text under the title.</td>
        </tr>
        <tr>
            <td class="font-bold">Description</td>
            <td>Optional smaller text under the title and/or excerpt. You might use this area on a singe promo view page and hide it from the catalog component.</td>
        </tr>
        <tr>
            <td class="font-bold">Primary image</td>
            <td>Minimum width of 600px jpg, png.</td>
        </tr>
    </tbody>
</table>
';

        $components['components'] = [
            'accordion' => [
                'data' => [
                    0 => [
                        'title' => 'Component configuration',
                        'promo_item_id' => 'componentConfiguration',
                        'description' => $component_configuration,
                    ],
                    1 => [
                        'title' => 'Promotion group details',
                        'promo_item_id' => 'promotionGroupDetails',
                        'description' => $promotion_group_details,
                    ],
                ],
                'component' => [
                    'filename' => 'accordion',
                ],
            ],
            'catalog-1' => [
                'data' => app(GenericPromo::class)->create(5, false, [
                    'description' => '',
                ]),
                'component' => [
                    'heading' => 'Three-column catalog',
                    'filename' => 'catalog',
                    'columns' => '3',
                    'showDescription' => false,
                    'gradientOverlay' => false,
                ],
            ],
            'catalog-10' => [
                'data' => app(GenericPromo::class)->create(5, false, [
                    'relative_url' => '/styleguide/image/450x600',
                    'description' => '',
                ]),
                'component' => [
                    'heading' => 'Three-column catalog',
                    'filename' => 'catalog',
                    'columns' => '3',
                    'showDescription' => false,
                    'gradientOverlay' => true,
                ],
            ],
            'catalog-2' => [
                'data' => app(GenericPromo::class)->create(3, false, [
                    'excerpt' => '',
                ]),
                'component' => [
                    'heading' => 'One-column catalog',
                    'filename' => 'catalog',
                    'columns' => '1',
                    'showDescription' => false,
                ],
            ],
            'catalog-3' => [
                'data' => app(PromoWithOptions::class)->create(8, false, [
                    'excerpt' => '',
                ]),
                'component' => [
                    'heading' => 'Catalog sorted by option',
                    'filename' => 'catalog',
                    'columns' => '4',
                    'showDescription' => false,
                    'groupByOptions' => true,
                ],
            ],
        ];

        $components['components']['catalog-3']['data'] = $this->components->organizePromoItemsByOption($components['components']['catalog-3']['data']);

        return view('childpage', merge($request->data, $components));
    }
}
