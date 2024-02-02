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
        $request->data['base']['page']['content']['main'] = '
<p>Accordions are helpful for pages where a person needs to scan a number of (more than 8) headings and choosing a single item to get information. If there is a need to directly link to this one item or for someone to print a single item, an accordion is not helpful. Accordions may shorten pages and reduce scrolling, but they increase the time and effort spent by requiring people to select various topic headings in order to locate the information they need.</p>
<p>Accordions should be treated as a last resort, if and only if the content meets ALL of the following criteria.</p>
<ol>
    <li>The list has more than five to eight items on it.</li>
    <li>The user would be scanning the list for one, at max two, items.</li>
    <li>Opening the accordion reveals the content of 1-2 paragraphs, no more.</li>
    <li>The content in the accordions does not need to be linked to (no deep-linking).</li>
</ol>
<p>If there are more than five to eight headings, consider using a table of contents that anchors/links to each heading.</p>
<p>Having all the content on the screen provides a better user experience, allowing users to:</p>
<ul>
    <li>reference multiple pieces of information at once</li>
    <li>utilize the CTRL+F find on the page</li>
    <li>scan headings</li>
    <li>determine if they are on the right page without having to take any action (click).</li>
</ul>

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
            <td>Text on the closed accordion.</td>
        </tr>
        <tr>
            <td class="font-bold">Description</td>
            <td>Content when the accordion is clicked open.</td>
        </tr>
    </tbody>
</table>
';
        $component_configuration = '
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
</table>
';

        $components['components'] = [
            'accordion' => [
                'data' => [
                    0 => [
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
