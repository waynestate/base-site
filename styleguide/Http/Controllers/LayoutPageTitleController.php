<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;

class LayoutPageTitleController extends Controller
{
    /**
     * Construct the controller.
     */
    public function __construct(Factory $faker)
    {
        $this->faker = $faker->create();
    }

    /**
     * Display the double header view with a custom short title
     */
    public function index(Request $request): View
    {
        $request->data['base']['page']['content']['main'] = '
<p>In the <code>modular-layout-config</code>, set whether a page title should be displayed.</p>
<ul>
<li><code>true</code> (Default option) shows the page title normally with margin top classes.</li>
<li><code>false</code> hides the page title (applies a <code>visually-hidden</code> class for accessibility).</li>
</ul>
<p>If <code>showTitle</code> is omitted, the default is visible.</p>
';

        return view('childpage', merge($request->data));
    }
}
