<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;
use Factories\HeroImage;

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
     * Article Listing Controller
     */
    public function index(Request $request): View
    {

        $component_config_title = 'Hero component configuration';
        $component_config_description = '
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
<p>The last array item cannot have a comma.</p>
<p><a href="https://github.com/waynestate/parse-promos">View the promo config documentation on Github.</a></p>
        </td>
    </tr>
</table> ';

        $promo_group_setup_title  = 'Hero promo group setup';
        $promo_group_setup_description = '
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
            <td>None, Text overlay, Logo overlay, SVG overlay</td>
        </tr>
    </tbody>
</table>';

        $components['components'] = [
            'accordion-1' => [
                'data' => [
                    0 => [
                        'title' => $component_config_title,
                        'description' => $component_config_description,
                        'promo_item_id' => 0,
                    ],
                    1 => [
                        'title' => $promo_group_setup_title,
                        'description' => $promo_group_setup_description,
                        'promo_item_id' => 1,
                    ],
                ],
                'component' => [
                    'filename' => 'accordion',
                    'columns' => '4',
                    'showDescription' => false,
                ],
            ],
        ];

        return view('modularpage', merge($request->data, $components));
    }
}
