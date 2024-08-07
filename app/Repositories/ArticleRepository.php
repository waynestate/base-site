<?php

namespace App\Repositories;

use Waynestate\Api\News;
use Illuminate\Cache\Repository;
use Contracts\Repositories\ArticleRepositoryContract;

class ArticleRepository implements ArticleRepositoryContract
{
    /** @var News */
    protected $newsApi;

    /** @var Repository */
    protected $cache;

    /**
     * Construct the repository.
     */
    public function __construct(News $newsApi, Repository $cache)
    {
        $this->newsApi = $newsApi;
        $this->cache = $cache;
    }

    /**
     * {@inheritdoc}
     */
    public function listing($application_ids, $limit = 5, $page = 1, $topics = [])
    {
        if (empty($application_ids)) {
            return ['articles' => []];
        }

        $params = [
            'perPage' =>  $limit,
            'page' => $page,
            'application_ids' => $application_ids,
            'method' => 'articles',
            'env' => config('app.env'),
        ];

        if (!empty($topics)) {
            $params['method'] = 'articles/topics';
            $params['topics'] = $topics;
        }

        $articles['articles'] = $this->cache->remember($params['method'].md5(serialize($params)), config('cache.ttl'), function () use ($params) {
            try {
                return $this->newsApi->request($params['method'], $params);
            } catch (\Exception $e) {
                return [];
            }
        });

        return $articles;
    }

    /**
     * {@inheritdoc}
     */
    public function find($id, $application_ids, $preview = null)
    {
        $params = [
            'method' => 'articles/'.$id,
            'application_ids' => $application_ids,
            'preview' => $preview,
        ];

        $article['article'] = $this->cache->remember($params['method'].md5(serialize($params)), $preview ? 0 : config('cache.ttl'), function () use ($params) {
            return $this->newsApi->request($params['method'], $params);
        });

        return $article;
    }

    /**
     * {@inheritdoc}
     */
    public function getCanonicalUrl(array $article, array $request)
    {
        // Fallback if there is no route path defined for news
        if (empty($article) || empty($request['site']['news']['route_path'])) {
            return $request['server']['url'] ?? '';
        }

        // Use the domain of the current page
        $uri = parse_url($request['server']['url']);

        // Build up the fully qualified URL for the article
        return
            trim($uri['scheme'] . '://' . $uri['host'] . '/' . $request['site']['subsite-folder'], '/') .
            str_replace(
                ['{$permalink}', '{$id}'],
                [$article['permalink'], $article['id']],
                $request['site']['news']['route_path']
            );
    }

    /**
     * {@inheritdoc}
     */
    public function getSocialImage($article)
    {
        if (!empty($article['social_image'])) {
            return [
                'url' => $article['social_image']['url'],
                'alt_text' => $article['social_image']['alt_text'],
            ];
        }

        if (!empty($article['featured'])) {
            return [
                'url' => $article['featured']['url'],
                'alt_text' => $article['featured']['alt_text'],
            ];
        }

        if (!empty($article['hero_image'])) {
            return [
                'url' => $article['hero_image']['url'],
                'alt_text' => $article['hero_image']['alt_text'],
            ];
        }

        if (!empty($article['body'])) {
            $doc = new \DOMDocument();
            @$doc->loadHTML($article['body']);
            $images = $doc->getElementsByTagName('img');

            if ($images->item(0) !== null) {
                return [
                    'url' => $images->item(0)->getAttribute('src'),
                    'alt_text' => $images->item(0)->getAttribute('alt'),
                ];
            }
        }

        return [
            'url' => null,
            'alt_text' => null,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function setPaging($meta, $page)
    {
        if (empty($page)) {
            $meta['next_page_url'] = null;
            $meta['prev_page_url'] = ($meta['total'] < $meta['per_page']) ? null : url()->current().'?page=2';
        } elseif ($page == $meta['last_page']) {
            $meta['next_page_url'] = url()->current().'?page='.($page - 1);
            $meta['prev_page_url'] = null;
        } else {
            $meta['next_page_url'] = url()->current().(($page - 1 == 1) ? '' : '?page='.($page - 1));
            $meta['prev_page_url'] = url()->current().'?page='.($page + 1);
        }

        return $meta;
    }
}
