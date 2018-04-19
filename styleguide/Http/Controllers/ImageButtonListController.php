<?php

namespace Styleguide\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImageButtonListController extends Controller
{
    /**
     * Display the image list with carousel view.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $promos['imagebutton'] = app('Factories\ImageButton')->create(50);

        return view('styleguide-image-button-list', merge($request->data, $promos));
    }
}
