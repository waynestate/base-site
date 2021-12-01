<?php

namespace Styleguide\Http\Controllers;

use App\Http\Controllers\Controller;
use Factories\Accordion;
use Illuminate\Http\Request;
use Faker\Factory;

class BasicLayoutsController extends Controller
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
        return view('styleguide-basic-layouts', merge($request->data, $this->faker));
    }
}