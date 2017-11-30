<?php

namespace Styleguide\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AccordionController extends Controller
{
    /**
     * Display an example accordion.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        return view('styleguide-accordion', merge($request->data));
    }
}
