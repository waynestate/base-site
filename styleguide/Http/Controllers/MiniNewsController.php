<?php

namespace Styleguide\Http\Controllers;

use Contracts\Repositories\NewsRepositoryContract;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class MiniNewsController extends Controller
{
    /**
     * Construct the controller.
     *
     * @param NewsRepositoryContract $news
     */
    public function __construct(NewsRepositoryContract $news)
    {
        $this->news = $news;
    }

    /**
     * Display the mini news.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $news = $this->news->getNewsByDisplayOrder($request->data['site']['id']);

        return view('styleguide-mininews', merge($request->data, $news));
    }
}
