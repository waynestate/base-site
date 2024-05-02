<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CMSColorsController extends Controller
{
    /**
     * Display the styleguide view.
     */
    public function index(Request $request): View
    {
        return view('styleguide-cms-colors', merge($request->data));
    }
}
