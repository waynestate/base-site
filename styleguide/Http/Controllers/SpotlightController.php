<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;
use Factories\Spotlight;
use Factories\GenericPromo;

class SpotlightController extends Controller
{
    /**
     * Construct the controller.
     */
    public function __construct(Factory $faker)
    {
        $this->faker = $faker->create();
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
                <pre class="w-full">modular-spotlight-column-1</pre>
                <pre class="w-full">modular-spotlight-row-1</pre>
            </td>
            <td>
<pre class="w-full" tabindex="0">
{
"id":000000,
"heading":"Spotlight",
"config":"randomize|page_id|limit:1",
"singlePromoView":false,
"showDescription":false
}
</pre>
            </td>
        </tr>
    </tbody>
</table>',
                    ],
                    1 => [
                        'promo_item_id' => 0,
                        'title' => 'Promo group setup',
                        'description' => '
<table class="mt-2">
    <thead>
        <tr>
            <th colspan="2">Available fields</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td class="font-bold">Title</td>
            <td>Displays as a cited name below the quote.</td>
        </tr>
        <tr>
            <td class="font-bold">Link</td>
            <td>Optional external link. Component flag "singlePromoView" sets the link to the individual promo item view.</td>
        </tr>
        <tr>
            <td class="font-bold">Excerpt</td>
            <td>Main quote area by default. If component flag "showDescription" is set to true, excerpt can display underneath the name like a degree or job title.<br />Accepts only these html entities: <code>&amp;ldquo;</code><code>&amp;rdquo;</code><code>&lt;em&gt;</code><code>&lt;strong&gt;</code><code>&lt;br /&gt;</code>.</td>
        </tr>
        <tr>
            <td class="font-bold">Description</td>
            <td>Can be used as the quote area if the component flag "showDescription" is set to true.</td>
        </tr>
        <tr>
            <td class="font-bold">Filename</td>
            <td>Primary promo image, 600x600px or any square size. Other sizes will be centered to fit in the circle.</td>
        </tr>
    </tbody>
</table>',
                    ],
                ],
                'component' => [
                    'filename' => 'accordion',
                ],
            ],
            'spotlight-1' => [
                'data' => app(Spotlight::class)->create(1, false, [
                    'link' => '',
                ]),
                'component' => [
                    'heading' => 'Spotlight column',
                    'filename' => 'spotlight-column',
                    'showDescription' => true,
                ],
            ],
            'spotlight-2' => [
                'data' => app(GenericPromo::class)->create(1, false, [
                    'title' => $this->faker->name,
                    'excerpt' => '&ldquo;' . $this->faker->text(200) . '&rdquo;',
                ]),
                'component' => [
                    'heading' => 'Spotlight row',
                    'filename' => 'spotlight-row',
                ],
            ],
        ];

        return view('childpage', merge($request->data, $components));
    }
}
