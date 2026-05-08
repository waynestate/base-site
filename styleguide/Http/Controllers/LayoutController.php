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
<p>If a site requires an entirely custom layout, a developer can create a new file within the layouts directory
and set the layout variable to the new filename within the "base.config" file.</p>
<code>\'layout\' => \'main\'</code>
';
        // Override layout
        if ($request->data['base']['page']['id'] === 120100100) {
            $request->data['base']['layout'] = 'main';
        }

        return view('childpage', merge($request->data));
    }
}
