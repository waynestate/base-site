<?php
/*
* Status: Private
* Description: Article Template
* Default: false
*/

namespace App\Http\Controllers;

use Contracts\Repositories\ArticleRepositoryContract;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Construct the controller.
     *
     * @param ArticleRepositoryContract $article
     */
    public function __construct(ArticleRepositoryContract $article)
    {
        $this->article = $article;
    }

    /**
     * Display the articles.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Get the articles
        $articles = $this->article->listing([7], 25, $request->query('page'));

        // Disable hero images
        $request->data['hero'] = false;

        return view('articles', merge($request->data, $articles));
    }

    /**
     * Display the individual article.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function show(Request $request)
    {
        // Get the news item
        $article = $this->article->find($request->id, [7]);

        // If the news item does not exist or isn't published
        if (empty($article['article']['data']) || $article['article']['data']['status'] !== 'Published') {
            return abort('404');
        }

        // Set the page title to the news item title
        $request->data['page']['title'] = $article['article']['data']['title'];

        // Set hero
        if (!empty($article['article']['data']['hero_image']['url'])) {
            $request->data['hero'][]['relative_url'] = $article['article']['data']['hero_image']['url'];
        }

        // Set the meta image information
        $request->data['meta']['image'] = $this->article->getImageUrl($article['article']['data']);

        return view('article', merge($request->data, $article));
    }
}
