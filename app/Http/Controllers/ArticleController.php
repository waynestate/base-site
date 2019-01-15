<?php
/*
* Status: Private
* Description: Article Template
* Default: false
*/

namespace App\Http\Controllers;

use Contracts\Repositories\ArticleRepositoryContract;
use Contracts\Repositories\TopicRepositoryContract;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    /**
     * Construct the controller.
     *
     * @param ArticleRepositoryContract $article
     * @param TopicRepositoryContract $topic
     */
    public function __construct(ArticleRepositoryContract $article, TopicRepositoryContract $topic)
    {
        $this->article = $article;
        $this->topic = $topic;
    }

    /**
     * Display the articles.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        $topic['topic'] = null;

        // Get the topic
        if(!empty($request->slug)) {
            $topic = $this->topic->find(null, $request->slug);

            // 404 the page since the category doens't exist
            if(isset($topic['topic']['errors'])) {
                return abort('404');
            }
        }

        // Get the articles
        $articles = $this->article->listing([7], 25, $request->query('page'), !empty($topic['topic']['data']['id']) ? [$topic['topic']['data']['id']] : null);

        // Get topics url
        $articles['topics_url'] = $this->article->topicsUrl();

        // Disable hero images
        $request->data['hero'] = false;

        return view('articles', merge($request->data, $articles, $topic));
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
