<?php

namespace Styleguide\Http\Controllers;

use Contracts\Repositories\ModularPageRepositoryContract;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;
use Factories\EmptyPromo;

class ComponentLayoutConfigController extends Controller
{
    /**
     * Construct the controller.
     */
    public function __construct(
        Factory $faker,
        ModularPageRepositoryContract $components
    ) {
        $this->faker = $faker->create();
        $this->components = $components;
    }

    /**
     * Article Listing Controller
     */
    public function index(Request $request): View
    {
        $request->data['base']['page']['content']['main'] = '
<p class="text-lg">Modify template elements.</p>
            ';

        $components = [
            'promo-row-1' => [
                'data' => app(EmptyPromo::class)->create(1, false, [
                    'title' => 'Component configuration',
                    'description' => '
<table style="cell-padding: 5px;" class="mt-4 no-stripe">
<thead>
<tr>
<th class="md:w-2/5">Page field</th>
<th>Data</th>
</tr>
</thead>
<tbody>
<tr>
<td><pre class="w-full">modular-layout-config</pre></td>
<td><pre class="w-full">{
"showSiteMenu":false,
"showPageTitle":false,
"pageClass":"class-name",
}</pre></td>
</tr>
</tbody>
</table>
',
                ]),
                'component' => [
                    'filename' => 'promo-row',
                ],
            ],
            'promo-row-2' => [
                'data' => app(EmptyPromo::class)->create(1, false, [
                    'title' => 'Options',
                    'description' => '
<table>
<thead>
<tr>
<th>Option</th>
<th>Details</th>
</tr>
</thead>
<tbody>
<tr>
<td class="font-bold">showSiteMenu</td>
<td>Set to false to hide the left menu and display a full-width layout.</td>
</tr>
<tr>
<td class="font-bold">showPageTitle</td>
<td>Set to false to visually hide the page title.</td>
</tr>
<tr>
<td class="font-bold">pageClass</td>
<td>Add a class to the body of the page.</td>
</tr>
</table>
',
                ]),
                'component' => [
                    'filename' => 'promo-row',
                    'headingClass' => 'mt-0',
                    'classes' => '-mt-gutter'
                ],
            ],
        ];

        $components = $this->components->componentClasses($components);
        $components = $this->components->componentStyles($components);

        // Assign components globally
        $request->data['base']['components'] = $components;

        return view('childpage', merge($request->data));
    }
}
