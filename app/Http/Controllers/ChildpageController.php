<?php
/*
* Status: Public
* Description: Childpage Template
* Default: true
*/

namespace App\Http\Controllers;

use Illuminate\View\View;
use Illuminate\Http\Request;
use Contracts\Repositories\ModularPageRepositoryContract;

class ChildpageController extends Controller
{
    /**
     * Construct the controller.
     *
     */
    public function __construct(
        ModularPageRepositoryContract $components
    ) {
        $this->components = $components;
    }

    /**
     * Display the childpage view.
     */
    public function index(Request $request): View
    {

        return view('childpage', merge($request->data));
    }
}
