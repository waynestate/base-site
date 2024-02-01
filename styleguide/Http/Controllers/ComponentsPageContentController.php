<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ComponentsPageContentController extends Controller
{
    /**
     * Display page content from a page field
     */
    public function index(Request $request): View
    {
        $request->data['base']['page']['content']['main'] = '
<p style="margin-top: -1rem;">Move the CMS page content to the location of the <code>modular-page-content-row</code> or <code>modular-page-content-column</code> page field.</p>
';

        $component_configuration = '
<table class="mt-2">
    <thead>
        <tr>
            <th class="w-1/2">Page field</th>
            <th>Data</th>
        </tr>
    </thead>
    <tr>
        <td>
<pre class="w-full">modular-page-content-row</pre>
<pre class="w-full">modular-page-content-column</pre>
        </td>
        <td>
<pre class="w-full" tabindex="0">
{}
</pre>
        </td>
    </tr>
</table>
';

        $components['components'] = [
            'page-content-row' => [
                'data' => [
                    0 => [
                        'filename' => 'page-content',
                    ],
                ],
                'component' => [
                    'filename' => 'page-content-row',
                ],
            ],
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
        ];

        return view('childpage', merge($request->data, $components));
    }
}
