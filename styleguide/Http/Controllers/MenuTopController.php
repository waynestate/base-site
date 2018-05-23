<?php

namespace Styleguide\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Styleguide\Repositories\MenuRepository;

class MenuTopController extends Controller
{
    /**
     * Construct the MenuTopController.
     */
    public function __construct(MenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    /**
     * Display the top menu view.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        config(['base.top_menu_enabled' => true]);

        // Only get a few items to show for top menu so it doesn't mess up the display
        $top_menu = array_slice($request->data['top_menu']['menu'], 0, 4, true);

        // Parse the top menu again to override the to menu output
        $request->data['top_menu_output'] = $this->menuRepository->getTopMenuOutput($top_menu);

        return view('styleguide-childpage', merge($request->data));
    }
}
