<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;
use Factories\Icon;

class ComponentIconsController extends Controller
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
        $request->data['base']['page']['content']['main'] = '
<p>Present a list of promotional items accompanied by icons, offering a visually appealing and informative display.</p>
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
            <td>Optional smaller text under the title and/or excerpt. You might use this area on a singe promo view page and hide it from the component.</td>
        </tr>
        <tr>
            <td class="font-bold">Primary image</td>
            <td>Minimum width of 160px svg, png, jpg.</td>
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
                <pre class="w-full">modular-icons-column-1</pre>
            </td>
            <td>
<pre class="w-full" tabindex="0">
{
"id":000000,
"heading":"Icons column"
}
</pre>
            </td>
        </tr>
        <tr>
            <td>
                <pre class="w-full">modular-icons-row-1</pre>
            </td>
            <td>
<pre class="w-full" tabindex="0">
{
"id":000000,
"heading":"Icons row",
"columns":2
}
</pre>
            </td>
        </tr>
        <tr>
            <td>
                <pre class="w-full">modular-icons-top-row-1</pre>
            </td>
            <td>
<pre class="w-full" tabindex="0">
{
"id":000000,
"heading":"Icons top row",
"columns":4,
"showDescription":true
}
</pre>
            </td>
        </tr>
    </tbody>
</table>
';

        $components = [
            'accordion-1' => [
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
                    'showDescription' => false,
                ],
            ],
            'icons-column-1' => [
                'data' => app(Icon::class)->create(4, false, [
                    'description' => '',
                ]),
                'component' => [
                    'heading' => 'Icons column',
                    'filename' => 'icons-column',
                ],
            ],
            'icons-row-1' => [
                'data' => app(Icon::class)->create(4, false, [
                    'excerpt' => '',
                ]),
                'component' => [
                    'heading' => 'Icons row',
                    'filename' => 'icons-row',
                ],
            ],
            'icons-top-row-1' => [
                'data' => app(Icon::class)->create(4, false, [
                    'excerpt' => '',
                    'link' => '',
                ]),
                'component' => [
                    'heading' => 'Icons top row',
                    'filename' => 'icons-top-row',
                    'columns' => 4
                ],
            ],
        ];

        // Assign components globally
        $request->data['base']['components'] = $components;

        return view('childpage', merge($request->data));
    }
}
