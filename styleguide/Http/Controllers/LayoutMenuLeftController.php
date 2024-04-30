<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MenuLeftController extends Controller
{
    /**
     * Display menu left view.
     */
    public function index(Request $request): View
    {
        config(['base.top_menu_enabled' => false]);

        return view('styleguide-childpage', merge($request->data));
    }
}
