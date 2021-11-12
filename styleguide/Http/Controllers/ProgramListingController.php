<?php

namespace Styleguide\Http\Controllers;

use App\Http\Controllers\Controller;
use Factories\Accordion;
use Illuminate\Http\Request;
use Faker\Factory;

class ProgramListingController extends Controller
{
    /**
     * Construct the controller.
     *
     * @param Factory $faker
     */
    public function __construct(Factory $faker)
    {
        $this->faker['faker'] = $faker->create();
    }

    /**
     * Display the styleguide view.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('styleguide-program-listing', merge($request->data, $this->faker));
    }
}
