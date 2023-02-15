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
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function index(Request $request)
    {
        $topics = $this->topic->listing($request->data['base']['site']['news']['application_id'], $request->data['base']['site']['subsite-folder']);

        if (!empty($topics['topics']['data'])) {
            $topics['topics']['data'] = $this->topic->setSelected($topics['topics']['data'], $request->slug);

            $selected_topic = collect($topics['topics']['data'])->firstWhere('selected', true);
        }

        if (!empty($request->slug) && empty($selected_topic['selected'])) {
            abort('404');
        }

        $articles = $this->article->listing($request->data['base']['site']['news']['application_id'], 25, $request->query('page'), !empty($selected_topic['topic_id']) ? $selected_topic['topic_id'] : null);

        if (!empty($articles['articles']['meta'])) {
            $articles['articles']['meta'] = $this->article->setPaging($articles['articles']['meta'], $request->query('page'));
        }

        // Force the menu to be shown if categories are found
        if (!empty($topics['topics']['data'])) {
            $request->data['base']['show_site_menu'] = true;
        }

        return view('articles', merge($request->data, $articles, $topics));
    }

    /**
     * Display the individual article.
     *
     * @param Request $request
     * @return \Illuminate\View\View
     *
     * @throws \Symfony\Component\HttpKernel\Exception\HttpException
     * @throws \Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     */
    public function show(Request $request)
    {
        if (empty($request->data['base']['site']['news']['application_id'])) {
            abort('404');
        }

        $article = $this->article->find($request->id, $request->data['base']['site']['news']['application_id'], $request->preview);

        if (empty($article['article']['data'])) {
            if ($request->preview) {
                return redirect($request->server->get('REDIRECT_URL'));
            }

            abort('404');
        }

        $request->data['base']['page']['title'] = $article['article']['data']['title'];
        $request->data['page']['description'] = $article['article']['data']['meta_description'];
        $request->data['page']['canonical'] = $request->data['server']['url'] ?? '';

        if (!empty($article['article']['data']['hero_image']['url'])) {
            $request->data['base']['hero'][]['relative_url'] = $article['article']['data']['hero_image']['url'];
        }

        $image = $this->article->getImage($article['article']['data']);

        $request->data['base']['meta']['image'] = $image['url'];
        $request->data['base']['meta']['image_alt'] = $image['alt_text'];

        $topics = $this->topic->listing($request->data['base']['site']['news']['application_id']);

        if (!empty($topics['topics']['data'])) {
            $topics['topics']['data'] = $this->topic->setSelected($topics['topics']['data'], $request->slug);

            $selected_topic = collect($topics['topics']['data'])->firstWhere('selected', true);
        }

        // Force the menu to be shown if categories are found
        if (!empty($topics['topics']['data'])) {
            $request->data['base']['show_site_menu'] = true;
        }

        return view('article', merge($request->data, $article, $topics));
    }
}
