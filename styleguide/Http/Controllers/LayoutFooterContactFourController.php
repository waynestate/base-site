<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Factories\FooterContact;
use Illuminate\Http\Request;

class LayoutFooterContactFourController extends Controller
{
    /**
     * Display four column footer view.
     */
    public function index(Request $request): View
    {
        $request->data['base']['contact'] = app(FooterContact::class)->create(4);

        return view('styleguide-childpage', merge($request->data));
    }
}
