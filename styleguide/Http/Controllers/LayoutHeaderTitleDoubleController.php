<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;

class LayoutHeaderTitleDoubleController extends Controller
{
    /**
     * Construct the controller.
     * @param MenuRepositoryContract $menu
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
        $request->data['base']['surtitle'] = $this->faker->sentence($this->faker->numberBetween(2, 4));
        $request->data['base']['surtitle_url'] = '/';
        $request->data['base']['hasSurtitle'] = true;

        return view('childpage', merge($request->data));
    }
}
