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
"config":"page_id|limit:3"
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
"config":"page_id|limit:3",
"columns":3
}
</pre>
            </td>
        </tr>
    </tbody>
</table>
';

        $icon_green = "data:image/svg+xml;base64,PD94bWwgdmVyc2lvbj0iMS4wIiBlbmNvZGluZz0idXRmLTgiPz4KPCEtLSBHZW5lcmF0b3I6IEFkb2JlIElsbHVzdHJhdG9yIDI2LjAuMSwgU1ZHIEV4cG9ydCBQbHVnLUluIC4gU1ZHIFZlcnNpb246IDYuMDAgQnVpbGQgMCkgIC0tPgo8c3ZnIHZlcnNpb249IjEuMSIgaWQ9IkxheWVyXzEiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyIgeG1sbnM6eGxpbms9Imh0dHA6Ly93d3cudzMub3JnLzE5OTkveGxpbmsiIHg9IjBweCIgeT0iMHB4IgoJIHZpZXdCb3g9IjAgMCAxMDAgMTAwIiBzdHlsZT0iZW5hYmxlLWJhY2tncm91bmQ6bmV3IDAgMCAxMDAgMTAwOyIgeG1sOnNwYWNlPSJwcmVzZXJ2ZSI+CjxzdHlsZSB0eXBlPSJ0ZXh0L2NzcyI+Cgkuc3Qwe2ZpbGw6IzA4MzUyRjt9Cjwvc3R5bGU+CjxwYXRoIGNsYXNzPSJzdDAiIGQ9Ik01MCwyLjVDMjMuOCwyLjUsMi41LDIzLjgsMi41LDUwUzIzLjgsOTcuNSw1MCw5Ny41Uzk3LjUsNzYuMiw5Ny41LDUwUzc2LjIsMi41LDUwLDIuNXogTTQzLjgsMjAuOQoJYzEuNi0xLjUsMy41LTIuMiw1LjYtMi4yYzIuMiwwLDQuMSwwLjcsNS42LDIuMmMxLjYsMS41LDIuMywzLjIsMi4zLDUuM2MwLDItMC44LDMuOC0yLjQsNS4yYy0xLjYsMS40LTMuNCwyLjItNS42LDIuMgoJYy0yLjIsMC00LjEtMC43LTUuNi0yLjJjLTEuNi0xLjQtMi40LTMuMi0yLjQtNS4yQzQxLjQsMjQuMSw0Mi4yLDIyLjMsNDMuOCwyMC45eiBNNjMuMyw4MS4zSDM3Ljd2LTNjMC43LTAuMSwxLjQtMC4xLDIuMS0wLjIKCXMxLjMtMC4yLDEuNy0wLjRjMC45LTAuMywxLjUtMC44LDEuOC0xLjRzMC41LTEuNCwwLjUtMi40VjUwLjRjMC0wLjktMC4yLTEuOC0wLjYtMi41Yy0wLjQtMC43LTEtMS4zLTEuNi0xLjcKCWMtMC41LTAuMy0xLjItMC42LTIuMi0wLjlzLTEuOS0wLjUtMi43LTAuNnYtM2wxOS44LTEuMWwwLjYsMC42djMyLjFjMCwwLjksMC4yLDEuNywwLjYsMi40YzAuNCwwLjcsMSwxLjIsMS43LDEuNQoJYzAuNSwwLjIsMS4xLDAuNSwxLjgsMC42YzAuNiwwLjIsMS4zLDAuMywyLDAuNHYzLjFDNjMuMiw4MS4zLDYzLjMsODEuMyw2My4zLDgxLjN6Ii8+Cjwvc3ZnPgo=";
        $icon_white = "data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHZpZXdCb3g9IjAgMCAxMDAgMTAwIj48cGF0aCBkPSJNNTAgMi41QzIzLjggMi41IDIuNSAyMy44IDIuNSA1MFMyMy44IDk3LjUgNTAgOTcuNSA5Ny41IDc2LjIgOTcuNSA1MCA3Ni4yIDIuNSA1MCAyLjV6bS02LjIgMTguNGMxLjYtMS41IDMuNS0yLjIgNS42LTIuMiAyLjIgMCA0LjEuNyA1LjYgMi4yIDEuNiAxLjUgMi4zIDMuMiAyLjMgNS4zIDAgMi0uOCAzLjgtMi40IDUuMi0xLjYgMS40LTMuNCAyLjItNS42IDIuMi0yLjIgMC00LjEtLjctNS42LTIuMi0xLjYtMS40LTIuNC0zLjItMi40LTUuMi4xLTIuMS45LTMuOSAyLjUtNS4zem0xOS41IDYwLjRIMzcuN3YtM2MuNy0uMSAxLjQtLjEgMi4xLS4yczEuMy0uMiAxLjctLjRjLjktLjMgMS41LS44IDEuOC0xLjQuMy0uNi41LTEuNC41LTIuNFY1MC40YzAtLjktLjItMS44LS42LTIuNS0uNC0uNy0xLTEuMy0xLjYtMS43LS41LS4zLTEuMi0uNi0yLjItLjlzLTEuOS0uNS0yLjctLjZ2LTNsMTkuOC0xLjEuNi42djMyLjFjMCAuOS4yIDEuNy42IDIuNC40LjcgMSAxLjIgMS43IDEuNS41LjIgMS4xLjUgMS44LjYuNi4yIDEuMy4zIDIgLjR2My4xeiIgZmlsbD0iI2ZmZiIvPjwvc3ZnPg==";
        $svg_white = "data:image/svg+xml;base64,PHN2ZyBpZD0iTGF5ZXJfMSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIiB2aWV3Qm94PSIwIDAgMzYwIDEzMSI+PHN0eWxlPi5zdDB7ZmlsbDojZmZmfTwvc3R5bGU+PHBhdGggY2xhc3M9InN0MCIgZD0iTTM0OSA4Ny40VjEwLjhIMTF2MTA5aDE2MS44djJIOVY4LjhoMzQydjc4LjZoLTJ6Ii8+PHBhdGggY2xhc3M9InN0MCIgZD0iTTE3OS4yIDExMi41bC01LjYtMTguOWg0LjdsMy40IDEyLjloLjFsMy40LTEyLjloNC4ybC01LjYgMTguOXY5LjRoLTQuNXYtOS40em0xMC45LTEyLjJjMC00LjUgMi40LTcuMSA2LjgtNy4xczYuOCAyLjYgNi44IDcuMVYxMTVjMCA0LjUtMi40IDcuMS02LjggNy4xcy02LjgtMi42LTYuOC03LjF2LTE0Ljd6bTQuNCAxNWMwIDIgLjkgMi44IDIuMyAyLjhzMi4zLS44IDIuMy0yLjhWMTAwYzAtMi0uOS0yLjgtMi4zLTIuOHMtMi4zLjgtMi4zIDIuOHYxNS4zem0xNi4yLTIxLjh2MjEuOWMwIDIgLjkgMi44IDIuMyAyLjhzMi4zLS43IDIuMy0yLjhWOTMuNWg0LjJ2MjEuNmMwIDQuNS0yLjMgNy4xLTYuNiA3LjFzLTYuNi0yLjYtNi42LTcuMVY5My41aDQuNHptMjEuMiAyOC40Yy0uMi0uNy0uNC0xLjItLjQtMy41di00LjVjMC0yLjYtLjktMy42LTIuOS0zLjZIMjI3djExLjVoLTQuNVY5My41aDYuN2M0LjYgMCA2LjYgMi4xIDYuNiA2LjV2Mi4yYzAgMi45LS45IDQuOC0yLjkgNS43di4xYzIuMi45IDMgMyAzIDZ2NC40YzAgMS40IDAgMi40LjUgMy40aC00LjV6TTIyNyA5Ny42djguN2gxLjdjMS43IDAgMi43LS43IDIuNy0zdi0yLjhjMC0yLS43LTIuOS0yLjMtMi45SDIyN3ptMTcuOCAyLjdjMC00LjUgMi40LTcuMSA2LjgtNy4xczYuOCAyLjYgNi44IDcuMVYxMTVjMCA0LjUtMi40IDcuMS02LjggNy4xcy02LjgtMi42LTYuOC03LjF2LTE0Ljd6bTQuNCAxNWMwIDIgLjkgMi44IDIuMyAyLjhzMi4zLS44IDIuMy0yLjhWMTAwYzAtMi0uOS0yLjgtMi4zLTIuOHMtMi4zLjgtMi4zIDIuOHYxNS4zem0xOC42IDEuM2wzLjQtMjMuMWg0LjFsLTQuNCAyOC4zaC02LjZsLTQuNC0yOC4zaDQuNWwzLjQgMjMuMXptMTQtMTEuMWg2LjF2NGgtNi4xdjguM2g3Ljd2NGgtMTIuMVY5My41aDEyLjF2NGgtNy43djh6bTE5LjggMTYuNGMtLjItLjctLjQtMS4yLS40LTMuNXYtNC41YzAtMi42LS45LTMuNi0yLjktMy42aC0xLjV2MTEuNWgtNC41VjkzLjVoNi43YzQuNiAwIDYuNiAyLjEgNi42IDYuNXYyLjJjMCAyLjktLjkgNC44LTIuOSA1Ljd2LjFjMi4yLjkgMyAzIDMgNnY0LjRjMCAxLjQgMCAyLjQuNSAzLjRoLTQuNnptLTQuOS0yNC4zdjguN2gxLjdjMS43IDAgMi43LS43IDIuNy0zdi0yLjhjMC0yLS43LTIuOS0yLjMtMi45aC0yLjF6bTExLjgtNC4xaDQuNXYyNC4zaDcuM3Y0aC0xMS44VjkzLjV6bTI4LjIgMjguNGgtNC41bC0uOC01LjFoLTUuNWwtLjggNS4xSDMyMWw0LjUtMjguM2g2LjVsNC43IDI4LjN6bS0xMC4yLTloNC4zbC0yLjEtMTQuM2gtLjFsLTIuMSAxNC4zem0xNC40LS40bC01LjYtMTguOWg0LjdsMy40IDEyLjloLjFsMy40LTEyLjloNC4ybC01LjYgMTguOXY5LjRIMzQxdi05LjR6Ii8+PC9zdmc+";

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
            'excerpt' => '',
            'link' => '#.pdf',
            'relative_url' => $icon_green,
            'filename_alt_text' => 'Example green icon',
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
            'relative_url' => $icon_white,
            'filename_alt_text' => 'Example white icon',
            'link' => '#.pdf',
        ]);

        // Image
        $image[1] = app(Button::class)->create(1, true, [
            'title' => 'Image',
            'option' => 'Image',
            'relative_url' => "/styleguide/image/600x218?text=Primary+image+only",
            'filename_alt_text' => "Placeholder image",
        ]);

        // PDF
        $image[2] = app(Button::class)->create(1, true, [
            'title' => 'PDF',
            'option' => 'Image',
            'relative_url' => "/styleguide/image/600x218?text=Image+linking+to+a+pdf",
            'filename_alt_text' => "Placeholder image",
            'link' => '#.pdf',
        ]);

        // SVG overlay
        $image[3] = app(Button::class)->create(1, true, [
            'title' => 'SVG overlay on dark background',
            'option' => 'Image',
            'relative_url' => "/styleguide/image/600x218",
            'filename_alt_text' => "Dark background",
            'secondary_relative_url' => $svg_white,
            'secondary_alt_text' => 'SVG overlay on image background',
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
