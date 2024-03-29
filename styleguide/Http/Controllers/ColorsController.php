<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ColorsController extends Controller
{
    /**
     * Display the styleguide view.
     */
    public function index(Request $request): View
    {
        return view('styleguide-colors', merge($request->data));
    }
}
