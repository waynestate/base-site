<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;
use Factories\GenericPromo;

class SinglePromoController extends Controller
{
    /**
     * Construct the controller.
     */
    public function __construct(Factory $faker)
    {
        $this->faker['faker'] = $faker->create();
    }

    /**
     * Article Listing Controller
     */
    public function index(Request $request): View
    {
        $request->data['base']['page']['content']['main'] = '';

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
            <td>
Optional external link.<br />
Component flag "singlePromoView" sets the link to the individual promo item view.
            </td>
        </tr>
        <tr>
            <td class="font-bold">Excerpt</td>
            <td>Optional smaller text under the title.</td>
        </tr>
        <tr>
            <td class="font-bold">Description</td>
            <td>
Optional smaller text under the title and/or excerpt.<br />
You might use this area on a singe promo view page and hide it from the catalog component.
            </td>
        </tr>
        <tr>
            <td class="font-bold">Primary image</td>
            <td>Minimum width of 600px jpg, png.</td>
        </tr>
    </tbody>
</table>
';

        $component_configuration = '
<table class="no-stripe">
    <thead>
        <tr>
            <th class="w-2/5">Page field</th>
            <th>Data</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <pre class="w-full">modular-promo-column-1</pre>
            </td>
            <td>
<pre class="w-full" tabindex="0">
{
"id":000000,
"heading":"Promo column",
"config":"page_id|randomize|limit:1|youtube",
"singlePromoView":true,
"showExcerpt":true,
"showDescription":false,
"gradientOverlay":false
}
</pre>
            </td>
        </tr>
        <tr>
            <td>
                <pre class="w-full">modular-promo-row-1</pre>
            </td>
            <td>
<pre class="w-full" tabindex="0">
{
"id":000000,
"heading":"Promo row",
"config":"page_id|randomize|limit:1|youtube",
"singlePromoView":true,
"showExcerpt":true,
"showDescription":false,
}
</pre>
            </td>
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
            'promo-column-1' => [
                'data' => app(GenericPromo::class)->create(1, false, [
                    'excerpt' => '',
                ]),
                'component' => [
                    'heading' => 'Promo column',
                    'filename' => 'promo-column',
                ],
            ],
            'promo-column-2' => [
                'data' => app(GenericPromo::class)->create(1, false, [
                    'description' => '',
                ]),
                'component' => [
                    'heading' => 'Gradient overlay',
                    'filename' => 'promo-column',
                    'gradientOverlay' => true,
                ],
            ],
            'promo-row-1' => [
                'data' => app(GenericPromo::class)->create(1, false, [
                    'excerpt' => '',
                    'link' => '#',
                ]),
                'component' => [
                    'heading' => 'Promo row',
                    'filename' => 'promo-row',
                ],
            ],
        ];

        return view('childpage', merge($request->data, $components));
    }
}
