<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;

class LayoutHeaderTitleSingleController extends Controller
{
    /**
     * Construct the controller.
     */
    public function __construct(Factory $faker)
    {
        $this->faker = $faker->create();
    }

    /**
     * Display single title header view
     */
    public function index(Request $request): View
    {
        config([
            'base.top_menu_enabled' => true,
        ]);

        $request->data['base']['surtitle'] = null;
        $request->data['base']['surtitle_url'] = null;
        $request->data['base']['hasSurtitle'] = false;

        return view('childpage', merge($request->data));
    }
}
