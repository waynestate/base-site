<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Styleguide\Repositories\MenuRepository;

class LayoutMenuTopController extends Controller
{
    /**
     * Construct the controller.
     */
    public function __construct(MenuRepository $menuRepository)
    {
        $this->menuRepository = $menuRepository;
    }

    /**
     * Display the top menu view.
     */
    public function index(Request $request): View
    {
        config(['base.top_menu_enabled' => true]);

        // Only get a few items to show for top menu so it doesn't mess up the display
        $top_menu = array_slice($request->data['base']['top_menu']['menu'], 0, 4, true);

        // Parse the top menu again to override the to menu output
        $request->data['base']['top_menu_output'] = $this->menuRepository->getTopMenuOutput($top_menu);

        return view('styleguide-childpage', merge($request->data));
    }
}
