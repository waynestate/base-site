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
        $topics = $this->topic->listing($request->data['site']['news']['application_id']);

        if (!empty($topics['topics']['data'])) {
            $topics['topics']['data'] = $this->topic->setSelected($topics['topics']['data'], $request->slug);

            $selected_topic = collect($topics['topics']['data'])->firstWhere('selected', true);
        }

        if (!empty($request->slug) && empty($selected_topic['selected'])) {
            return abort('404');
        }

        $articles = $this->article->listing($request->data['site']['news']['application_id'], 25, $request->query('page'), !empty($selected_topic['topic_id']) ? $selected_topic['topic_id'] : null);

        if (!empty($articles['articles']['meta'])) {
            $articles['articles']['meta'] = $this->article->setPaging($articles['articles']['meta'], $request->query('page'));
        }

        $request->data['hero'] = false;

        // Force the menu to be shown if categories are found
        if (!empty($topics['topics']['data'])) {
            $request->data['show_site_menu'] = true;
        }

        return view('articles', merge($request->data, $articles, $topics));
    }

    /**
     * Display the individual article.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     */
    public function show(Request $request)
    {
        $article = $this->article->find($request->id, $request->data['site']['news']['application_id']);

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
