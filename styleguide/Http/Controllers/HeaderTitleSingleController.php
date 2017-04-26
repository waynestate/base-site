<?php

namespace Styleguide\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HeaderTitleSingleController extends Controller
{
    /**
     * Display single header view.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        config(['app.sub_title' => null]);

        return view('styleguide-childpage', merge($request->data));
    }
}
