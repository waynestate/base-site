<?php

namespace Styleguide\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImageListController extends Controller
{
    /**
     * Display the image list with carousel view.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $promos['imagebutton'] = app('Factories\ImageButton')->create(4);

        $promos['images'] = app('Factories\Image')->create(50);

        return view('styleguide-imagelist', merge($request->data, $promos));
    }
}
