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
     * @param ArticleRepositoryContract $articles
     */
    public function __construct(ArticleRepositoryContract $articles)
    {
        $this->articles = $articles;
    }

    /**
     * Display the news listing view.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Get the news categories
        $categories = $this->news->getCategories($request->data['site']['id'], $request->data['site']['subsite-folder'], true);

        // Set the selected category
        $categories = $this->news->setSelectedCategory($categories, $request->slug);

        // 404 the page since the category doens't exist or is inactive
        if ($request->slug !== null && empty($categories['selected_news_category']['category_id'])) {
            return abort('404');
        }

        // Get the news listing
        $news = $this->news->getNewsByPage($request->data['site']['id'], $request->query('page'), 25, $categories['selected_news_category']['category_id']);

        // Get the previous and next paging information
        $paging = $this->news->getPaging($request->query('page'), 25);

        // Disable hero images
        $request->data['hero'] = false;

        // Force the menu to be shown if categories are found
        if (!empty($categories['news_categories'])) {
            $request->data['show_site_menu'] = true;
        }

        return view('news-listing', merge($request->data, $news, $paging, $categories));
    }

    /**
     * Display the individual news item view.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function show(Request $request)
    {
        // Get the news item
        $news = $this->news->getNewsItem($request->id, $request->data['site']['id']);

        // If the news item does not belong in the archive and the time has expired, don't show it
        if (empty($news['news']) || !empty($news['error']) || $news['news']['archive'] == 0 && strtotime($news['news']['ending']) < time()) {
            return abort('404');
        }

        // Set the page title to the news item title
        $request->data['page']['title'] = $news['news']['title'];

        // Disable hero images
        $request->data['hero'] = false;

        // Get the news categories
        $categories = $this->news->getCategories($request->data['site']['id'], $request->data['site']['subsite-folder']);

        // Set the selected category
        $categories = $this->news->setSelectedCategory($categories, null);

        // Set hero
        if (!empty($news['news']['filename_url_relative'])) {
            $request->data['hero'][]['relative_url'] = $news['news']['filename_url_relative'];
        }

        // Set the meta image information
        $request->data['meta']['image'] = $this->news->getImageUrl($news);

        return view('news-individual', merge($request->data, $news, $categories));
    }
}
