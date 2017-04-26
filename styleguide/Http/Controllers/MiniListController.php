<?php

namespace Styleguide\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MiniListController extends Controller
{
    /**
     * Display the mini list view.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $promos['minilist'] = app('Factories\MiniList')->create(4);

        return view('styleguide-minilist', merge($request->data, $promos));
    }
}
