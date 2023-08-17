<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Factories\MiniList;
use Illuminate\Http\Request;

class MiniListController extends Controller
{
    /**
     * Display the mini list view.
     */
    public function index(Request $request): View
    {
        $promos['minilist'] = app(MiniList::class)->create(4);

        return view('styleguide-minilist', merge($request->data, $promos));
    }
}
