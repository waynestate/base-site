<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;
use Factories\Icon;

class IconsController extends Controller
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
                        'promo_item_id' => 0,
                        'title' => 'Configuration',
                        'description' => '
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
</table>',
                    ],
                ],
                'component' => [
                    'filename' => 'accordion',
                    'columns' => '4',
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

        return view('childpage', merge($request->data, $components));
    }
}
