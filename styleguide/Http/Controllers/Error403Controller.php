<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class Error403Controller extends Controller
{
    /**
     * Display the 403 error view.
     */
    public function index(Request $request): View
    {
        return view('errors.403', ['request' => $request]);
    }
}
