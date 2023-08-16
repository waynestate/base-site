<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;

class ButtonsController extends Controller
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
     * Display an example table stack.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request): View
    {
        return view('styleguide-buttons', merge($request->data, $this->faker));
    }
}
