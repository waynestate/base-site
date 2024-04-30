<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Error500Controller extends Controller
{
    /**
     * Display the 500 error view.
     */
    public function index(Request $request): View
    {
        return view('errors.500', ['request' => $request]);
    }
}
