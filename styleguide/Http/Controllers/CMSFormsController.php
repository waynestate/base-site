<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CMSFormsController extends Controller
{
    /**
     * Display the form view.
     */
    public function index(Request $request): View
    {
        return view('styleguide-cms-forms', merge($request->data));
    }
}
