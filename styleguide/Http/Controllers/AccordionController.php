<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Factories\AccordionItems;

class AccordionController extends Controller
{
    /**
     * Display an example accordion.
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
            <th>Page field</th>
            <th>Data</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <pre class="w-full">modular-accordion-1</pre>
            </td>
            <td>
<pre class="w-full" tabindex="0">
{
"id":000000,
"heading":"Accordion"
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
                ],
            ],
            'accordion-2' => [
                'data' => app(AccordionItems::class)->create(4, false),
                'component' => [
                    'heading' => 'My accordion',
                    'filename' => 'accordion',
                ],
            ],
            'accordion-3' => [
                'data' => app(AccordionItems::class)->create(3, false),
                'component' => [
                    'heading' => 'My second accordion',
                    'filename' => 'accordion',
                ],
            ],
        ];

        return view('childpage', merge($request->data, $components));
    }
}
