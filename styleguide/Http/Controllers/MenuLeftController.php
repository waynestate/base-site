<?php

namespace Styleguide\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MenuLeftController extends Controller
{
    /**
     * Display menu left view.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        config(['base.top_menu_enabled' => false]);

        return view('styleguide-childpage', merge($request->data));
    }
}
