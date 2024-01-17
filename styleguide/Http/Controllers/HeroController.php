<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;

class HeroController extends Controller
{
    /**
     * Construct the controller.
     */
    public function __construct(Factory $faker)
    {
        $this->faker['faker'] = $faker->create();
    }

    /**
     * Hero Controller
     */
    public function index(Request $request): View
    {

        $component_configuration = '
<table class="mt-2">
    <thead>
        <tr>
            <th>Page field</th>
            <th>Data</th>
        </tr>
    </thead>
    <tr>
        <td>
<pre class="w-full">modular-hero-1</pre>
        </td>
        <td>
<pre class="w-full" tabindex="0">
{
"id":0000,
"config":"randomize|page_id|limit:1"
}
</pre>
Note: Any limit above 1 will enable rotate.
        </td>
    </tr>
</table>
';

        $promotion_group_details = '
<table class="mt-2">
    <thead>
        <tr>
            <th colspan="2">Available fields</th>
        </tr>
    </thead>
    </tbody>
        <tr>
            <td class="font-bold">Title</td>
            <td>Displayed using options "Text overlay," "Logo overlay" and will become a link if link field is used.</td>
        </tr>
        <tr>
            <td class="font-bold">Link</td>
            <td>URL</td>
        </tr>
        <tr>
            <td class="font-bold">Description</td>
            <td>Formattable text. If the link field is set, description links will be stripped out.</td>
        </tr>
        <tr>
            <td class="font-bold">Filename</td>
            <td>1600x580px or 3200x1160px saved at low quality</td>
        </tr>
        <tr>
            <td class="font-bold">Options</td>
            <td>None, Skinny, Text overlay, Half, Logo overlay, SVG overlay</td>
        </tr>
    </tbody>
</table>';

        $components['components'] = [
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
                    'columns' => '4',
                    'showDescription' => false,
                ],
            ],
        ];

        return view('childpage', merge($request->data, $components));
    }
}
