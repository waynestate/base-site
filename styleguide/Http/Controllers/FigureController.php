<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;

class FigureController extends Controller
{
    /**
     * Construct the controller.
     */
    public function __construct(Factory $faker)
    {
        $this->faker['faker'] = $faker->create();
    }

    /**
     * Display an example table stack.
     */
    public function index(Request $request): View
    {
        return view('styleguide-figure', merge($request->data, $this->faker));
    }
}
