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
        $components['components'] = [
            'accordion-1' => [
                'data' => [
                    0 => [
                        'title' => 'Configuration',
                        'description' => '
<table>
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
                <pre class="w-full">modular-promo-row-1</pre>
            </td>
            <td>
<pre class="w-full" tabindex="0">
{
"id":000000,
"heading":"Promo",
"config":"randomize|limit:1|page_id",
"singlePromoView":true,
"showExcerpt":true,
"showDescription":false
}
</pre>
            </td>
        </tr>
    </tbody>
</table>',
                        'promo_item_id' => 0,
                    ],
                ],
                'component' => [
                    'filename' => 'accordion',
                    'columns' => '4',
                    'showDescription' => false,
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
