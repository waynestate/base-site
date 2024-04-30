<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Factories\GenericPromo;
use Factories\Event;

class ComponentHeadingController extends Controller
{
    /**
     * Display a page heading from a page field
     */
    public function index(Request $request): View
    {
        $request->data['base']['page']['content']['main'] = '
<p>Add a page heading that spans an entire row. Suggested to use over two related columns, like an "Events" heading over a promo-column featured image, and an events-column. You would not use this when you can add a heading to an individual component.</p>
';

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
<pre class="w-full">modular-heading</pre>
        </td>
        <td>
<pre class="w-full" tabindex="0">
{
"heading": "My heading"
}
</pre>
        </td>
    </tr>
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
                ],
                'component' => [
                    'filename' => 'accordion',
                ],
            ],
            'heading-1' => [
                'data' => [
                    0 => [
                        'heading' => 'My example heading',
                    ],
                ],
                'component' => [
                    'filename' => 'heading',
                ],
            ],
            'events-column' => [
                'data' => app(Event::class)->create(4, false),
                'component' => [
                    'filename' => 'events-column',
                    'calendar_url' => '/myurl'
                ],
            ],
            'promo-column-2' => [
                'data' => app(GenericPromo::class)->create(1, false, [
                    'title' => 'Featured event (promo column)',
                    'filename_url' => '/styleguide/image/600x600',
                    'description' => '',
                ]),
                'component' => [
                    'heading' => '',
                    'filename' => 'promo-column',
                    'gradientOverlay' => true,
                ],
            ],
        ];

        // Assign components globally
        $request->data['base']['components'] = $components;

        return view('childpage', merge($request->data, $components));
    }
}
