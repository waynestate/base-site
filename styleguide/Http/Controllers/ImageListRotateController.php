<?php

namespace Styleguide\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ImageListRotateController extends Controller
{
    /**
     * Display the image list with carousel view.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $promos['images'] = app('Factories\Image')->create(4);

        return view('styleguide-image-list-rotate', merge($request->data, $promos));
    }
}
