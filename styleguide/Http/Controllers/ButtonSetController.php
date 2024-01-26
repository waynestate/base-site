<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;
use Factories\Button;

class ButtonSetController extends Controller
{
    /**
     * Construct the controller.
     */
    public function __construct(Factory $faker)
    {
        $this->faker['faker'] = $faker->create();
    }

    /**
     * Display an example table stack.
     */
    public function index(Request $request): View
    {

        $request->data['base']['page']['content']['main'] = '
<p>This component serves as the buttons under the side menu and as button components on your page.</p>
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
            <td>Text to appear on the button.</td>
        </tr>
        <tr>
            <td class="font-bold">Link</td>
            <td>Your URL. When linking to a pdf, "(pdf)" is added automatically.</td>
        </tr>
        <tr>
            <td class="font-bold">Excerpt</td>
            <td>Add a 2-3 word second line of text.</td>
        </tr>
        <tr>
            <td class="font-bold">Options</td>
            <td>
                <strong>Default:</strong> Default, Green, Image<br />
                <strong>Options available by request:</strong> Green gradient, Gold, Gold gradient<br />View these colors on the <a href="/styleguide/buttons">Buttons</a> page.</p>
            </td>
        </tr>
        <tr>
            <td class="font-bold">Primary image</td>
            <td>
            Icons: 40x40px PNG, SVG<br />Images: 600x218px JPG, PNG recommended with descriptive alternative text.<br />Text within the image is not recommended because it cannot maintain readability when scaled.</td>
        </tr>
        <tr>
            <td class="font-bold">Secondary image</td>
            <td>SVG overlay image of the same dimensions as the primary image.<br />Text can be used within the SVG because it is scalable. You must provide enough contrast between the background and overlay image to meet accessibility standards. Secondary image alternative text not used.</td>
        </tr>
    </tbody>
</table>
';
        $component_configuration = '
<table class="no-stripe">
    <thead>
        <tr>
            <th class="md:w-2/5">Page field</th>
            <th>Data</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <pre class="w-full">modular-button-column-1</pre>
            </td>
            <td>
<pre class="w-full" tabindex="0">
{
"id":000000,
"heading":"Buttons",
"config":"limit:3"
}
</pre>
            </td>
        </tr>
        <tr>
            <td>
                <pre class="w-full">modular-button-row-1</pre>
            </td>
            <td>
<pre class="w-full" tabindex="0">
{
"id":000000,
"heading":"Buttons",
"config":"limit:3",
"columns":3
}
</pre>
            </td>
        </tr>
    </tbody>
</table>
';

        // Default button
        $default[1] = app(Button::class)->create(1, true, [
            'title' => 'Default button',
            'option' => 'Default',
        ]);

        // Default two lines
        $default[2] = app(Button::class)->create(1, true, [
            'title' => 'Two-line button',
            'option' => 'Default',
            'excerpt' => 'Excerpt text here',
        ]);

        // Default icon
        $default[3] = app(Button::class)->create(1, true, [
            'title' => 'Icon button',
            'option' => 'Default',
            'link' => '#.pdf',
            'filename_alt_text' => 'Example green icon',
            'icon' => true,
        ]);

        // Green button
        $green[1] = app(Button::class)->create(1, true, [
            'title' => 'Green button',
            'option' => 'Green',
            'link' => '#.pdf',
        ]);

        // Green two lines
        $green[2] = app(Button::class)->create(1, true, [
            'title' => 'Two-line button',
            'option' => 'Green',
            'excerpt' => 'Excerpt text here',
            'link' => '#.pdf',
        ]);

        // Green icon
        $green[3] = app(Button::class)->create(1, true, [
            'title' => 'Icon button',
            'option' => 'Green',
            'excerpt' => 'Excerpt text here',
            'link' => '#.pdf',
            'icon' => true,
        ]);

        // Image
        $image[1] = app(Button::class)->create(1, true, [
            'title' => 'Image',
            'option' => 'Image',
            'relative_url' => "/styleguide/image/600x218?text=Primary+image+only",
        ]);

        // PDF
        $image[2] = app(Button::class)->create(1, true, [
            'title' => 'PDF',
            'option' => 'Image',
            'relative_url' => "/styleguide/image/600x218?text=Image+linking+to+a+pdf",
            'link' => '#.pdf',
        ]);

        // SVG overlay
        $image[3] = app(Button::class)->create(1, true, [
            'title' => 'SVG overlay on dark background',
            'option' => 'Image',
            'overlay' => true,
        ]);

        // Use them as components
        $components = [
            'accordion' => [
                'data' => [
                    2 => [
                        'promo_item_id' => 'componentConfiguration',
                        'title' => 'Component configuration',
                        'description' => $component_configuration,
                    ],
                    1 => [
                        'promo_item_id' => 'promoGroupDetails',
                        'title' => 'Promotion group details',
                        'description' => $promotion_group_details,
                    ],
                ],
                'component' => [
                    'filename' => 'accordion',
                ],
            ],
            'button_row_1' => [
                'data' => app(Button::class)->create(3, false, [
                    'option' => 'Green',
                ]),
                'component' => [
                    'heading' => 'Button row',
                    'filename' => 'button-row',
                    'columns' => 3
                ],
            ],
            'button_column_1' => [
                'data' => app(Button::class)->create(3, false, [
                    'option' => 'Green',
                ]),
                'component' => [
                    'heading' => 'Button column',
                    'filename' => 'button-column',
                ],
            ],
            'button_column_2' => [
                'data' => $default,
                'component' => [
                    'heading' => 'Default buttons',
                    'filename' => 'button-column',
                ],
            ],
            'button_column_3' => [
                'data' => $green,
                'component' => [
                    'heading' => 'Green buttons',
                    'filename' => 'button-column',
                ],
            ],
            'button_column_4' => [
                'data' => $image,
                'component' => [
                    'heading' => 'Image buttons',
                    'filename' => 'button-column',
                ],
            ],
        ];

        return view('styleguide-button-set', merge($request->data, $components));
    }
}
