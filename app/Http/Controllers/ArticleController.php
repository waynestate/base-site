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

        if (!empty($request->slug)) {
            $topic = $this->topic->find(null, $request->slug);

            if (isset($topic['topic']['errors'])) {
                return abort('404');
            }
        }

        $articles = $this->article->listing([7], 25, $request->query('page'), !empty($topic['topic']['data']['id']) ? [$topic['topic']['data']['id']] : null);

        $articles['topics_url'] = $this->article->topicsUrl();

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
        $article = $this->article->find($request->id, [7]);

        if (empty($article['article']['data']) || $article['article']['data']['status'] !== 'Published') {
            return abort('404');
        }

        $request->data['page']['title'] = $article['article']['data']['title'];

        if (!empty($article['article']['data']['hero_image']['url'])) {
            $request->data['hero'][]['relative_url'] = $article['article']['data']['hero_image']['url'];
        }

        $request->data['meta']['image'] = $this->article->getImageUrl($article['article']['data']);

        return view('article', merge($request->data, $article));
    }
}
