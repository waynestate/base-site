<?php

namespace Styleguide\Http\Controllers;

use Contracts\Repositories\ModularPageRepositoryContract;
use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Faker\Factory;
use Factories\GenericPromo;
use Factories\PromoWithOptions;

class ComponentCatalogController extends Controller
{
    /**
     * Catalog Controller
     */
    public function index(Request $request): View
    {
        // Delete me
        return view('childpage', $request->data);
    }
}
