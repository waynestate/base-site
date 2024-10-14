<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;

class LayoutController extends Controller
{
    /**
     * Construct the controller.
     */
    public function __construct(Factory $faker)
    {
        $this->faker['faker'] = $faker->create();
    }

    /**
     * Layout Controller
     */
    public function index(Request $request): View
    {
        $request->data['base']['page']['content']['main'] = '
<p>In the base.config, set a site layout to use for all pages.</p>
<ul>
<li><code>main</code> uses the small banner hero by default.</li>
<li><code>contained-hero</code> uses the contained hero by default.</li>
</ul>
';
        // Override layout
        if ($request->data['base']['page']['id'] === 120100100) {
            $request->data['base']['layout'] = 'main';
        }

        if ($request->data['base']['page']['id'] === 120100101) {
            $request->data['base']['layout'] = 'contained-hero';
        }

        return view('childpage', merge($request->data));
    }
}
