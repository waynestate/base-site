<?php

namespace Tests\Unit\Repositories;

use App\Repositories\ArticleRepository;
use Factories\Article;
use Tests\TestCase;
use Mockery as Mockery;
use Waynestate\Api\News;

class ArticleRepositoryTest extends TestCase
{
    /**
     * @covers \App\Repositories\ArticleRepository::find
     * @test
     */
    public function finding_article_should_return_article()
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

    /**
     * @covers \App\Repositories\ArticleRepository::listing
     * @test
     */
    public function getting_articles_should_return_array_of_articles()
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

    /**
    * @covers \App\Repositories\ArticleRepository::listing
    * @covers \App\Repositories\ArticleRepository::setPaging
    * @test
    */
    public function articles_paging_while_on_first_page()
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

    /**
    * @covers \App\Repositories\ArticleRepository::listing
    * @covers \App\Repositories\ArticleRepository::setPaging
    * @test
    */
    public function articles_paging_while_on_last_page()
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

    /**
     * @covers \App\Repositories\ArticleRepository::listing
     * @covers \App\Repositories\ArticleRepository::setPaging
     * @test
     */
    public function articles_paging_no_page()
    {
        // Fake return
        $return = app(Article::class)->create(5);

        // Mock the connector and set the return
        $newsApi = Mockery::mock(News::class);
        $newsApi->shouldReceive('request')->andReturn($return);

        $page = null;

        $articles = app(ArticleRepository::class, ['newsApi' => $newsApi])->listing(1, 5, $page);

        $articles['articles']['meta'] = app(ArticleRepository::class, ['newsApi' => $newsApi])->setPaging($articles['articles']['meta'], $page);

        $next = parse_url($articles['articles']['meta']['next_page_url']);
        $this->assertTrue(empty($next['page']));

        $prev = parse_url($articles['articles']['meta']['prev_page_url']);
        parse_str($prev['query'], $prev);
        $this->assertEquals(2, $prev['page']);
    }

    /**
     * @covers \App\Repositories\ArticleRepository::listing
     * @test
     */
    public function getting_articles_with_no_applications()
    {
        $articles = app(ArticleRepository::class)->listing([]);

        $this->assertCount(0, $articles['articles']);
    }

    /**
     * @covers \App\Repositories\ArticleRepository::listing
     * @test
     */
    public function getting_articles_with_exception_should_return_empty_array()
    {
        // Fake return
        $return = app(Article::class)->create(5);

        // Mock the connector and set the return
        $newsApi = Mockery::mock(News::class);
        $newsApi->shouldReceive('request')->andThrow(new \Exception());

        $articles = app(ArticleRepository::class, ['newsApi' => $newsApi])->listing(1);

        $this->assertCount(0, $articles['articles']);
    }

    /**
     * @covers \App\Repositories\ArticleRepository::getImage
     * @test
     */
    public function article_with_no_images_should_return_null()
    {
        $article = app(Article::class)->create(1, true, [
            'files' => null,
            'body' => null,
        ]);

        $imageUrl = app(ArticleRepository::class)->getImage($article);

        $this->assertNull($imageUrl['url']);
        $this->assertNull($imageUrl['alt_text']);
    }

    /**
     * @covers \App\Repositories\ArticleRepository::getImage
     * @test
     */
    public function article_with_hero_should_return_hero_url()
    {
        $article = app(Article::class)->create(1, true);

        $imageUrl = app(ArticleRepository::class)->getImage($article['data']);

        $this->assertEquals($article['data']['hero_image']['url'], $imageUrl['url']);
        $this->assertEquals($article['data']['hero_image']['alt_text'], $imageUrl['alt_text']);
    }

    /**
     * @covers \App\Repositories\ArticleRepository::getImage
     * @test
     */
    public function article_with_body_image_should_return_url()
    {
        $url = $this->faker->imageUrl();
        $alt = $this->faker->word();

        $article = app(Article::class)->create(1, true, [
            'hero_image' => null,
            'body' => '<img src="'.$url.'" alt="'.$alt.'">',
        ]);

        $image = app(ArticleRepository::class)->getImage($article['data']);

        $this->assertEquals($url, $image['url']);
        $this->assertEquals($alt, $image['alt_text']);
    }
}
