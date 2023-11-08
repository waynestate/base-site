<?php

namespace Styleguide\Http\Controllers;

use Illuminate\View\View;
use Contracts\Repositories\ArticleRepositoryContract;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArticleListingController extends Controller
{
    /**
     * Construct the controller.
     */
    public function __construct(ArticleRepositoryContract $article)
    {
        $this->article = $article;
    }

    /**
     * Display the articles.
     */
    public function index(Request $request): View
    {
        $articles = $this->article->listing($request->data['base']['site']['id'], 4);

        return view('styleguide-article-listing', merge($request->data, $articles));
    }
}
