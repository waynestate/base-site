<?php

namespace App\Repositories;

use Contracts\Repositories\ArticleRepositoryContract;
use GuzzleHttp\Exception\ClientException;
use Illuminate\Cache\Repository;
use Waynestate\Api\News;
use App\Traits\StaleCache;

class ArticleRepository implements ArticleRepositoryContract
{
    use StaleCache;

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
            'perPage' => $limit,
            'page' => $page,
            'application_ids' => $application_ids,
            'method' => 'articles',
            'env' => config('app.env'),
        ];

        if (! empty($topics)) {
            $params['method'] = 'articles/topics';
            $params['topics'] = $topics;
        }

        // Let failures reach rememberWithFallback (don't catch them in here) so it falls back to the last good copy instead of caching no articles
        $articles['articles'] = $this->rememberWithFallback($params['method'].md5(serialize($params)), config('cache.ttl'), function () use ($params) {
            return $this->newsApi->request($params['method'], $params);
        }, [], function ($value) {
            // The news API returns false instead of throwing for some failures
            return is_array($value);
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

        // Previews are never cached, and skip the last good copy too since it could be an old draft
        if ($preview) {
            try {
                $article['article'] = $this->requestArticle($params);
            } catch (\Throwable $e) {
                $this->abortWhenRateLimited($e);

                throw $e;
            }

            return $article;
        }

        // Set by reference inside the closure, which PHPStan can't see
        /** @var \Throwable|null $failure */
        $failure = null;

        // Fall back to the last good copy when the news API fails
        $article['article'] = $this->rememberWithFallback($params['method'].md5(serialize($params)), config('cache.ttl'), function () use ($params, &$failure) {
            try {
                return $this->requestArticle($params);
            } catch (\Throwable $e) {
                // Keep the failure so it can be reported if there's no last good copy
                $failure = $e;

                throw $e;
            }
        }, null, function ($value) {
            // The news API returns false instead of throwing for some failures
            return is_array($value);
        });

        // The news API failed and there's no last good copy, so report it instead of showing a real article as a 404
        if ($article['article'] === null) {
            if ($failure !== null) {
                $this->abortWhenRateLimited($failure);

                throw $failure;
            }

            // The news API returned nothing instead of throwing, so it's still treated as a missing article
            $article['article'] = [];
        }

        return $article;
    }

    /**
     * Request an article from the news API.
     *
     * @throws \Throwable
     */
    protected function requestArticle(array $params)
    {
        try {
            return $this->newsApi->request($params['method'], $params);
        } catch (ClientException $e) {
            // A 404 is the news API answering that the article doesn't exist, so it's returned like a good response
            if ($e->getResponse()->getStatusCode() == 404) {
                return [];
            }

            throw $e;
        }
    }

    /**
     * Show the 429 page instead of a 500 when the news API rate limits.
     */
    protected function abortWhenRateLimited(\Throwable $e): void
    {
        if ($e instanceof ClientException && $e->getResponse()->getStatusCode() == 429) {
            abort(429);
        }
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
            trim($uri['scheme'].'://'.$uri['host'].'/'.$request['site']['subsite-folder'], '/').
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
        if (! empty($article['social_image'])) {
            return [
                'url' => $article['social_image']['url'],
                'alt_text' => $article['social_image']['alt_text'],
            ];
        }

        if (! empty($article['featured'])) {
            return [
                'url' => $article['featured']['url'],
                'alt_text' => $article['featured']['alt_text'],
            ];
        }

        if (! empty($article['hero_image'])) {
            return [
                'url' => $article['hero_image']['url'],
                'alt_text' => $article['hero_image']['alt_text'],
            ];
        }

        if (! empty($article['body'])) {
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
    public function setPaging(array $meta, ?int $page): array
    {
        if (empty($page)) {
            $meta['next_page_url'] = null;
            $meta['prev_page_url'] = ($meta['total'] <= $meta['per_page']) ? null : url()->current().'?page=2';
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
