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

        // // Get the news categories
        // $categories = $this->news->getCategories($request->data['site']['id'], $request->data['site']['subsite-folder'], true);

        // // Set the selected category
        // $categories = $this->news->setSelectedCategory($categories, $request->slug);

        // // 404 the page since the category doens't exist or is inactive
        // if ($request->slug !== null && empty($categories['selected_news_category']['category_id'])) {
        //     return abort('404');
        // }

        // // Get the articles
        $articles = $this->article->listing([7], 25, $request->query('page'));
        //dd($articles['articles']['data']);

        // // Get the previous and next paging information
        // $paging = $this->news->getPaging($request->query('page'), 25);

        // // Disable hero images
        $request->data['hero'] = false;

        // // Force the menu to be shown if categories are found
        // if (!empty($categories['news_categories'])) {
        //     $request->data['show_site_menu'] = true;
        // }

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

        // Get the news categories
        // $categories = $this->news->getCategories($request->data['site']['id'], $request->data['site']['subsite-folder']);

        // Set the selected category
        // $categories = $this->news->setSelectedCategory($categories, null);

        // Set hero
        if (!empty($article['article']['data']['hero_image']['url'])) {
            $request->data['hero'][]['relative_url'] = $article['article']['data']['hero_image']['url'];
        }

        // Set the meta image information
        $request->data['meta']['image'] = $this->article->getImageUrl($article['article']['data']);

        return view('article', merge($request->data, $article));
    }
}
