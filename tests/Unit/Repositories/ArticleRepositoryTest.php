<?php

namespace Tests\Unit\Repositories;

use PHPUnit\Framework\Attributes\Test;
use App\Repositories\ArticleRepository;
use Factories\Article;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Tests\TestCase;
use Mockery as Mockery;
use Waynestate\Api\News;

final class ArticleRepositoryTest extends TestCase
{
    #[Test]
    public function finding_article_should_return_article(): void
    {
        // Fake return
        $return = app(Article::class)->create(1, true);

        // Mock the connector and set the return
        $newsApi = Mockery::mock(News::class);
        $newsApi->shouldReceive('request')->andReturn($return);

        // Get the news categories
        $article = app(ArticleRepository::class, ['newsApi' => $newsApi])->find($this->faker->randomDigit(), $this->faker->randomDigit());

        // Make sure they are the same as the ones we created
        $this->assertEquals($return['data']['id'], $article['article']['data']['id']);
    }

    #[Test]
    public function getting_articles_should_return_array_of_articles(): void
    {
        // Fake return
        $return = app(Article::class)->create(5);

        // Mock the connector and set the return
        $newsApi = Mockery::mock(News::class);
        $newsApi->shouldReceive('request')->andReturn($return);

        // Get the articles
        $articles = app(ArticleRepository::class, ['newsApi' => $newsApi])->listing(1, 5, $this->faker->randomDigit(), [$this->faker->word()]);

        $this->assertEquals($return['data'], $articles['articles']['data']);
    }

    #[Test]
    public function articles_paging_while_on_first_page(): void
    {
        // Fake return
        $return = app(Article::class)->create(5);

        // Mock the connector and set the return
        $newsApi = Mockery::mock(News::class);
        $newsApi->shouldReceive('request')->andReturn($return);

        $page = 1;

        $articles = app(ArticleRepository::class, ['newsApi' => $newsApi])->listing(1, 5, $page);

        $articles['articles']['meta'] = app(ArticleRepository::class, ['newsApi' => $newsApi])->setPaging($articles['articles']['meta'], $page);

        $next = parse_url($articles['articles']['meta']['next_page_url']);
        parse_str($next['query'], $next);
        $this->assertEquals(0, $next['page']);

        $prev = parse_url($articles['articles']['meta']['prev_page_url']);
        parse_str($prev['query'], $prev);
        $this->assertEquals(2, $prev['page']);
    }

    #[Test]
    public function articles_paging_while_on_last_page(): void
    {
        // Fake return
        $return = app(Article::class)->create(5);

        // Mock the connector and set the return
        $newsApi = Mockery::mock(News::class);
        $newsApi->shouldReceive('request')->andReturn($return);

        $page = 3;

        $articles = app(ArticleRepository::class, ['newsApi' => $newsApi])->listing(1, 5, $page);

        $articles['articles']['meta'] = app(ArticleRepository::class, ['newsApi' => $newsApi])->setPaging($articles['articles']['meta'], $page);

        $next = parse_url($articles['articles']['meta']['next_page_url']);
        parse_str($next['query'], $next);
        $this->assertEquals(2, $next['page']);

        $prev = parse_url($articles['articles']['meta']['prev_page_url']);
        $this->assertTrue(empty($prev['page']));
    }

    #[Test]
    public function articles_paging_no_page_with_more_than_limit(): void
    {
        $total_articles = 10;
        $per_page = 5;
        // Fake return
        $return = app(Article::class)->create($total_articles);

        // Mock the connector and set the return
        $newsApi = Mockery::mock(News::class);
        $newsApi->shouldReceive('request')->andReturn($return);

        $page = null;

        $articles = app(ArticleRepository::class, ['newsApi' => $newsApi])->listing(1, $per_page, $page);

        $articles['articles']['meta']['total'] = $total_articles;
        $articles['articles']['meta']['per_page'] = $per_page;
        $articles['articles']['meta'] = app(ArticleRepository::class, ['newsApi' => $newsApi])
            ->setPaging($articles['articles']['meta'], $page);

        $next = parse_url($articles['articles']['meta']['next_page_url']);
        $this->assertTrue(empty($next['page']));

        $prev = parse_url($articles['articles']['meta']['prev_page_url']);
        parse_str($prev['query'], $prev);
        $this->assertEquals(2, $prev['page']);
    }

    #[Test]
    public function articles_paging_no_page_with_same_or_less_than_limit(): void
    {
        $total_articles = 5;
        $per_page = 5;
        // Fake return
        $return = app(Article::class)->create($total_articles);

        // Mock the connector and set the return
        $newsApi = Mockery::mock(News::class);
        $newsApi->shouldReceive('request')->andReturn($return);

        $page = null;

        $articles = app(ArticleRepository::class, ['newsApi' => $newsApi])->listing(1, $per_page, $page);

        $articles['articles']['meta']['total'] = $total_articles;
        $articles['articles']['meta']['per_page'] = $per_page;
        $articles['articles']['meta'] = app(ArticleRepository::class, ['newsApi' => $newsApi])
            ->setPaging($articles['articles']['meta'], $page);

        $next = parse_url($articles['articles']['meta']['next_page_url']);
        $this->assertTrue(empty($next['page']));

        $prev = parse_url($articles['articles']['meta']['prev_page_url']);
        $this->assertTrue(empty($prev['page']));
    }

    #[Test]
    public function getting_articles_with_no_applications(): void
    {
        $articles = app(ArticleRepository::class)->listing([]);

        $this->assertCount(0, $articles['articles']);
    }

    #[Test]
    public function getting_articles_with_exception_should_return_empty_array(): void
    {
        // Fake return
        $return = app(Article::class)->create(5);

        // Mock the connector and set the return
        $newsApi = Mockery::mock(News::class);
        $newsApi->shouldReceive('request')->andThrow(new \Exception());

        $articles = app(ArticleRepository::class, ['newsApi' => $newsApi])->listing(1);

        $this->assertCount(0, $articles['articles']);
    }

    #[Test]
    public function article_with_no_images_should_return_null(): void
    {
        $article = app(Article::class)->create(1, true, [
            'files' => null,
            'body' => null,
        ]);

        $imageUrl = app(ArticleRepository::class)->getSocialImage($article);

        $this->assertNull($imageUrl['url']);
        $this->assertNull($imageUrl['alt_text']);
    }

    #[Test]
    public function article_with_hero_should_return_hero_url(): void
    {
        $article = app(Article::class)->create(1, true, [
            'social_image' => null,
            'featured' => null,
        ]);

        $imageUrl = app(ArticleRepository::class)->getSocialImage($article['data']);

        $this->assertEquals($article['data']['hero_image']['url'], $imageUrl['url']);
        $this->assertEquals($article['data']['hero_image']['alt_text'], $imageUrl['alt_text']);
    }

    #[Test]
    public function article_with_body_image_should_return_url(): void
    {
        $url = $this->faker->imageUrl();
        $alt = $this->faker->word();

        $article = app(Article::class)->create(1, true, [
            'hero_image' => null,
            'featured' => null,
            'social_image' => null,
            'body' => '<img src="'.$url.'" alt="'.$alt.'">',
        ]);

        $image = app(ArticleRepository::class)->getSocialImage($article['data']);

        $this->assertEquals($url, $image['url']);
        $this->assertEquals($alt, $image['alt_text']);
    }

    #[Test]
    public function article_with_social_image_should_return_url(): void
    {
        $article = app(Article::class)->create(1, true);

        $imageUrl = app(ArticleRepository::class)->getSocialImage($article['data']);

        $this->assertEquals($article['data']['social_image']['url'], $imageUrl['url']);
        $this->assertEquals($article['data']['social_image']['alt_text'], $imageUrl['alt_text']);
    }

    #[Test]
    public function article_with_featured_image_should_return_url(): void
    {
        $article = app(Article::class)->create(1, true, [
            'social_image' => null
        ]);

        $imageUrl = app(ArticleRepository::class)->getSocialImage($article['data']);

        $this->assertEquals($article['data']['featured']['url'], $imageUrl['url']);
        $this->assertEquals($article['data']['featured']['alt_text'], $imageUrl['alt_text']);
    }

    #[Test]
    public function article_with_news_route_should_return_canonical_url(): void
    {
        $article = app(Article::class)->create(
            1,
            true,
            [
            'permalink' => 'permalink',
            'id' => 123,
        ]
        );

        $request = [
            'server' => ['url' => 'https://example.com/subsite/news/slug-id'],
            'site' => [
                'subsite-folder' => 'subsite/',
                'news' => ['route_path' => '/news/{$permalink}-{$id}'],
            ],
        ];

        $url = app(ArticleRepository::class)->getCanonicalUrl($article['data'], $request);

        $this->assertEquals($url, 'https://example.com/subsite/news/permalink-123');
    }

    #[Test]
    public function finding_article_when_news_api_rate_limits_should_abort_with_429(): void
    {
        $id = $this->faker->numberBetween(1, 100);

        // Mock the News API to respond with a 429
        $newsApi = Mockery::mock(News::class);
        $newsApi->shouldReceive('request')->once()->andThrow($this->clientException($id, 429));

        try {
            app(ArticleRepository::class, ['newsApi' => $newsApi])->find($id, $this->faker->numberBetween(1, 100));

            $this->fail('Expected a 429 HttpException');
        } catch (HttpException $e) {
            $this->assertEquals(429, $e->getStatusCode());
        }
    }

    #[Test]
    public function finding_article_when_news_api_has_other_client_error_should_rethrow(): void
    {
        $id = $this->faker->numberBetween(1, 100);

        // Mock the News API to respond with a 403
        $newsApi = Mockery::mock(News::class);
        $newsApi->shouldReceive('request')->once()->andThrow($this->clientException($id, 403));

        $this->expectException(ClientException::class);

        app(ArticleRepository::class, ['newsApi' => $newsApi])->find($id, $this->faker->numberBetween(1, 100));
    }

    #[Test]
    public function finding_article_when_news_api_rate_limits_should_fall_back_to_last_good_article(): void
    {
        config(['cache.ttl' => 60]);

        $id = $this->faker->numberBetween(1, 100);
        $application_id = $this->faker->numberBetween(1, 100);
        $return = app(Article::class)->create(1, true);

        // Mock the News API to succeed once and then rate limit
        $newsApi = Mockery::mock(News::class);
        $newsApi->shouldReceive('request')->twice()->andReturnUsing(
            fn () => $return,
            fn () => throw $this->clientException($id, 429)
        );

        $articleRepository = app(ArticleRepository::class, ['newsApi' => $newsApi]);

        $articleRepository->find($id, $application_id);

        // Expire the good copy so the next request goes back to the API and fails
        $this->travel(61)->seconds();

        $this->assertEquals($return, $articleRepository->find($id, $application_id)['article']);

        $this->travelBack();
    }

    #[Test]
    public function finding_article_that_doesnt_exist_should_be_cached_as_empty(): void
    {
        config(['cache.ttl' => 60]);

        $id = $this->faker->numberBetween(1, 100);
        $application_id = $this->faker->numberBetween(1, 100);

        // The News API should only be called once
        $newsApi = Mockery::mock(News::class);
        $newsApi->shouldReceive('request')->once()->andThrow($this->clientException($id, 404));

        $articleRepository = app(ArticleRepository::class, ['newsApi' => $newsApi]);

        $articleRepository->find($id, $application_id);

        $this->assertEquals(['article' => []], $articleRepository->find($id, $application_id));
    }

    #[Test]
    public function finding_article_when_news_api_returns_false_should_not_be_cached(): void
    {
        config(['cache.ttl' => 60]);

        $id = $this->faker->numberBetween(1, 100);
        $application_id = $this->faker->numberBetween(1, 100);
        $return = app(Article::class)->create(1, true);

        // Mock the News API to fail without throwing once and then succeed
        $newsApi = Mockery::mock(News::class);
        $newsApi->shouldReceive('request')->twice()->andReturn(false, $return);

        $articleRepository = app(ArticleRepository::class, ['newsApi' => $newsApi]);

        // It's still treated as a missing article like before
        $this->assertEquals(['article' => []], $articleRepository->find($id, $application_id));

        // The failure should not be cached, so the next request goes back to the API
        $this->assertEquals($return, $articleRepository->find($id, $application_id)['article']);
    }

    #[Test]
    public function previewing_article_should_not_use_last_good_copy(): void
    {
        config(['cache.ttl' => 60]);

        $id = $this->faker->numberBetween(1, 100);
        $application_id = $this->faker->numberBetween(1, 100);

        // Mock the News API to return a draft and then nothing once the article is published
        $newsApi = Mockery::mock(News::class);
        $newsApi->shouldReceive('request')->twice()->andReturn(app(Article::class)->create(1, true), null);

        $articleRepository = app(ArticleRepository::class, ['newsApi' => $newsApi]);

        $articleRepository->find($id, $application_id, true);

        // The old draft shouldn't be shown
        $this->assertEquals(['article' => null], $articleRepository->find($id, $application_id, true));
    }

    #[Test]
    public function previewing_article_that_doesnt_exist_should_return_empty(): void
    {
        $id = $this->faker->numberBetween(1, 100);

        $newsApi = Mockery::mock(News::class);
        $newsApi->shouldReceive('request')->once()->andThrow($this->clientException($id, 404));

        $this->assertEquals(['article' => []], app(ArticleRepository::class, ['newsApi' => $newsApi])->find($id, $this->faker->numberBetween(1, 100), true));
    }

    #[Test]
    public function previewing_article_when_news_api_rate_limits_should_abort_with_429(): void
    {
        $id = $this->faker->numberBetween(1, 100);

        $newsApi = Mockery::mock(News::class);
        $newsApi->shouldReceive('request')->once()->andThrow($this->clientException($id, 429));

        try {
            app(ArticleRepository::class, ['newsApi' => $newsApi])->find($id, $this->faker->numberBetween(1, 100), true);

            $this->fail('Expected a 429 HttpException');
        } catch (HttpException $e) {
            $this->assertEquals(429, $e->getStatusCode());
        }
    }

    #[Test]
    public function previewing_article_when_news_api_has_other_client_error_should_rethrow(): void
    {
        $id = $this->faker->numberBetween(1, 100);

        // Mock the News API to respond with a 403
        $newsApi = Mockery::mock(News::class);
        $newsApi->shouldReceive('request')->once()->andThrow($this->clientException($id, 403));

        $this->expectException(ClientException::class);

        app(ArticleRepository::class, ['newsApi' => $newsApi])->find($id, $this->faker->numberBetween(1, 100), true);
    }

    #[Test]
    public function getting_articles_with_exception_should_not_be_cached(): void
    {
        config(['cache.ttl' => 60]);

        $return = app(Article::class)->create(5);

        // Mock the News API to fail once and then succeed
        $newsApi = Mockery::mock(News::class);
        $newsApi->shouldReceive('request')->twice()->andReturnUsing(
            fn () => throw new \Exception('API is down'),
            fn () => $return
        );

        $articleRepository = app(ArticleRepository::class, ['newsApi' => $newsApi]);

        $this->assertEquals(['articles' => []], $articleRepository->listing(1));

        // The failure should not be cached, so the next request goes back to the API
        $this->assertEquals($return['data'], $articleRepository->listing(1)['articles']['data']);
    }

    #[Test]
    public function getting_articles_when_news_api_returns_false_should_not_be_cached(): void
    {
        config(['cache.ttl' => 60]);

        $return = app(Article::class)->create(5);

        // Mock the News API to fail without throwing once and then succeed
        $newsApi = Mockery::mock(News::class);
        $newsApi->shouldReceive('request')->twice()->andReturn(false, $return);

        $articleRepository = app(ArticleRepository::class, ['newsApi' => $newsApi]);

        $this->assertEquals(['articles' => []], $articleRepository->listing(1));

        $this->assertEquals($return['data'], $articleRepository->listing(1)['articles']['data']);
    }

    #[Test]
    public function getting_articles_with_exception_should_fall_back_to_last_good_articles(): void
    {
        config(['cache.ttl' => 60]);

        $return = app(Article::class)->create(5);

        // Mock the News API to succeed once and then fail
        $newsApi = Mockery::mock(News::class);
        $newsApi->shouldReceive('request')->twice()->andReturnUsing(
            fn () => $return,
            fn () => throw new \Exception('API is down')
        );

        $articleRepository = app(ArticleRepository::class, ['newsApi' => $newsApi]);

        $articles = $articleRepository->listing(1);

        // Expire the good copy so the next request goes back to the API and fails
        $this->travel(61)->seconds();

        $this->assertNotEmpty($articles['articles']['data']);
        $this->assertEquals($articles, $articleRepository->listing(1));

        $this->travelBack();
    }

    /**
     * A news API client error with the given status code.
     */
    private function clientException(int $id, int $status): ClientException
    {
        return new ClientException('News API error', new Request('GET', 'articles/'.$id), new Response($status));
    }
}
