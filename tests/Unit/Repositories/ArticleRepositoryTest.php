<?php

namespace Tests\App\Repositories;

use Tests\TestCase;
use Mockery as Mockery;

class ArticleRepositoryTest extends TestCase
{
    /**
     * @covers App\Repositories\ArticleRepository::find
     * @test
     */
    public function finding_article_should_return_article()
    {
        // Fake return
        $return = app('Factories\Article')->create(1, true);

        // Mock the connector and set the return
        $newsApi = Mockery::mock('Waynestate\Api\News');
        $newsApi->shouldReceive('request')->andReturn($return);

        // Get the news categories
        $article = app('App\Repositories\ArticleRepository', ['newsApi' => $newsApi])->find($this->faker->randomDigit, $this->faker->randomDigit);

        // Make sure they are the same as the ones we created
        $this->assertEquals($return['data']['id'], $article['article']['data']['id']);
    }

    /**
     * @covers App\Repositories\ArticleRepository::listing
     * @test
     */
    public function getting_articles_should_return_array_of_articles()
    {
        // Fake return
        $return = app('Factories\Article')->create(5);

        // Mock the connector and set the return
        $newsApi = Mockery::mock('Waynestate\Api\News');
        $newsApi->shouldReceive('request')->andReturn($return);

        // Get the articles
        $articles = app('App\Repositories\ArticleRepository', ['newsApi' => $newsApi])->listing(1, 5, $this->faker->randomDigit, [$this->faker->word]);

        $this->assertEquals($return['data'], $articles['articles']['data']);
    }

    /**
    * @covers App\Repositories\ArticleRepository::listing
    * @covers App\Repositories\ArticleRepository::setPaging
    * @test
    */
    public function articles_paging_while_on_first_page()
    {
        // Fake return
        $return = app('Factories\Article')->create(5);

        // Mock the connector and set the return
        $newsApi = Mockery::mock('Waynestate\Api\News');
        $newsApi->shouldReceive('request')->andReturn($return);

        $page = 1;

        $articles = app('App\Repositories\ArticleRepository', ['newsApi' => $newsApi])->listing(1, 5, $page);

        $articles['articles']['meta'] = app('App\Repositories\ArticleRepository', ['newsApi' => $newsApi])->setPaging($articles['articles']['meta'], $page);

        $next = parse_url($articles['articles']['meta']['next_page_url']);
        parse_str($next['query'], $next);
        $this->assertEquals(0, $next['page']);

        $prev = parse_url($articles['articles']['meta']['prev_page_url']);
        parse_str($prev['query'], $prev);
        $this->assertEquals(2, $prev['page']);
    }

    /**
    * @covers App\Repositories\ArticleRepository::listing
    * @covers App\Repositories\ArticleRepository::setPaging
    * @test
    */
    public function articles_paging_while_on_last_page()
    {
        // Fake return
        $return = app('Factories\Article')->create(5);

        // Mock the connector and set the return
        $newsApi = Mockery::mock('Waynestate\Api\News');
        $newsApi->shouldReceive('request')->andReturn($return);

        $page = 3;

        $articles = app('App\Repositories\ArticleRepository', ['newsApi' => $newsApi])->listing(1, 5, $page);

        $articles['articles']['meta'] = app('App\Repositories\ArticleRepository', ['newsApi' => $newsApi])->setPaging($articles['articles']['meta'], $page);

        $next = parse_url($articles['articles']['meta']['next_page_url']);
        parse_str($next['query'], $next);
        $this->assertEquals(2, $next['page']);

        $prev = parse_url($articles['articles']['meta']['prev_page_url']);
        $this->assertTrue(empty($prev['page']));
    }

    /**
     * @covers App\Repositories\ArticleRepository::listing
     * @covers App\Repositories\ArticleRepository::setPaging
     * @test
     */
    public function articles_paging_no_page()
    {
        // Fake return
        $return = app('Factories\Article')->create(5);

        // Mock the connector and set the return
        $newsApi = Mockery::mock('Waynestate\Api\News');
        $newsApi->shouldReceive('request')->andReturn($return);

        $page = null;

        $articles = app('App\Repositories\ArticleRepository', ['newsApi' => $newsApi])->listing(1, 5, $page);

        $articles['articles']['meta'] = app('App\Repositories\ArticleRepository', ['newsApi' => $newsApi])->setPaging($articles['articles']['meta'], $page);

        $next = parse_url($articles['articles']['meta']['next_page_url']);
        $this->assertTrue(empty($next['page']));

        $prev = parse_url($articles['articles']['meta']['prev_page_url']);
        parse_str($prev['query'], $prev);
        $this->assertEquals(2, $prev['page']);
    }

    /**
     * @covers App\Repositories\ArticleRepository::listing
     * @test
     */
    public function getting_articles_with_no_applications()
    {
        $articles = app('App\Repositories\ArticleRepository')->listing([]);

        $this->assertCount(0, $articles['articles']);
    }

    /**
     * @covers App\Repositories\ArticleRepository::listing
     * @test
     */
    public function getting_articles_with_exception_should_return_empty_array()
    {
        // Fake return
        $return = app('Factories\Article')->create(5);

        // Mock the connector and set the return
        $newsApi = Mockery::mock('Waynestate\Api\News');
        $newsApi->shouldReceive('request')->andThrow(new \Exception);

        $articles = app('App\Repositories\ArticleRepository', ['newsApi' => $newsApi])->listing(1);

        $this->assertCount(0, $articles['articles']);
    }

    /**
     * @covers App\Repositories\ArticleRepository::getImageUrl
     * @test
     */
    public function article_with_no_images_should_return_null()
    {
        $article = app('Factories\Article')->create(1, true, [
            'files' => null,
            'body' => null,
        ]);

        $imageUrl = app('App\Repositories\ArticleRepository')->getImageUrl($article);

        $this->assertNull($imageUrl);
    }

    /**
     * @covers App\Repositories\ArticleRepository::getImageUrl
     * @test
     */
    public function article_with_hero_should_return_hero_url()
    {
        $article = app('Factories\Article')->create(1, true);

        $imageUrl = app('App\Repositories\ArticleRepository')->getImageUrl($article['data']);

        $this->assertEquals($article['data']['hero_image']['url'], $imageUrl);
    }

    /**
     * @covers App\Repositories\ArticleRepository::getImageUrl
     * @test
     */
    public function article_with_body_image_should_return_url()
    {
        $image = $this->faker->imageUrl();

        $article = app('Factories\Article')->create(1, true, [
            'hero_image' => null,
            'body' => '<img src="'.$image.'">',
        ]);

        $imageUrl = app('App\Repositories\ArticleRepository')->getImageUrl($article['data']);

        $this->assertEquals($image, $imageUrl);
    }
}
