<?php

namespace Styleguide\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Error403Controller extends Controller
{
    /**
     * Display the 403 error view.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('errors.403', ['request' => $request]);
    }
}
