<?php

namespace Styleguide\Http\Controllers;

use Contracts\Repositories\ArticleRepositoryContract;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArticleListingController extends Controller
{
    /**
     * Construct the controller.
     *
     * @param ArticleRepositoryContract $news
     */
    public function __construct(ArticleRepositoryContract $article)
    {
        $this->article = $article;
    }

    /**
     * Display the mini news.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $articles = $this->article->listing($request->data['site']['id']);

        return view('styleguide-article-listing', merge($request->data, $articles));
    }
}
