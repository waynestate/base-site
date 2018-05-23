<?php

namespace Styleguide\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HeroFullMenuController extends Controller
{
    /**
     * Display the full width hero view.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        config(['base.hero_contained' => false]);

        return view('styleguide-childpage', merge($request->data));
    }
}
