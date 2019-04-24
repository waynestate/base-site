<?php

namespace Styleguide\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class FooterContactFourController extends Controller
{
    /**
     * Display four column footer view.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $request->data['contact'] = app('Factories\FooterContact')->create(4);

        return view('styleguide-childpage', merge($request->data));
    }
}
