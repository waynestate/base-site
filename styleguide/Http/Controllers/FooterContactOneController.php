<?php

namespace Styleguide\Http\Controllers;

use App\Http\Controllers\Controller;
use Factories\FooterContact;
use Illuminate\Http\Request;

class FooterContactOneController extends Controller
{
    /**
     * Display the one column footer view.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $request->data['base']['contact'] = app(FooterContact::class)->create(1);

        return view('styleguide-childpage', merge($request->data));
    }
}
