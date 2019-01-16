<?php

namespace Tests\App\Http\Controllers;

use Tests\TestCase;
use Mockery as Mockery;
use Illuminate\Http\Request;

class ArticleControllerTest extends TestCase
{
    /**
     * @covers App\Http\Controllers\ArticleController::__construct
     * @covers App\Http\Controllers\ArticleController::show
     * @expectedException Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @test
     */
    public function news_view_with_no_item_should_404()
    {
        // Fake return
        $return = app('Factories\ApiError')->create(1, true);

        // Mock the connector
        $newsApi = Mockery::mock('Waynestate\Api\News');
        $newsApi->shouldReceive('request')->andReturn($return);

        // Construct the news repository
        $articleRepository = app('App\Repositories\ArticleRepository', ['newsApi' => $newsApi]);

        // Construct the news controller
        $articleController = app('App\Http\Controllers\ArticleController', ['article' => $articleRepository]);

        // Call the news listing
        $view = $articleController->show(new Request());
    }

    /**
     * @covers App\Http\Controllers\ArticleController::show
     * @expectedException Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @test
     */
    public function news_item_that_is_not_published_should_404()
    {
        // Fake return
        $return = [
            'news' => app('Factories\Article')->create(1, true, [
                'status' => 'draft',
            ]),
        ];

        // Mock the connector
        $newsApi = Mockery::mock('Waynestate\Api\News');
        $newsApi->shouldReceive('request')->andReturn($return);

        // Construct the news repository
        $articleRepository = app('App\Repositories\ArticleRepository', ['newsApi' => $newsApi]);

        // Construct the news controller
        $articleController = app('App\Http\Controllers\ArticleController', ['article' => $articleRepository]);

        // Call the news listing
        $view = $articleController->show(new Request());
    }

    /**
     * @covers App\Http\Controllers\ArticleController::show
     * @test
     */
    public function page_title_should_be_news_item_title()
    {
        // Fake return
        $return = app('Factories\Article')->create(1);

        // Fake request
        $request = new Request();
        $request->data = app('Factories\Page')->create(1, true);

        // Mock the connector
        $newsApi = Mockery::mock('Waynestate\Api\News');
        $newsApi->shouldReceive('request')->andReturn($return);

        // Construct the news repository
        $ArticleRepository = app('App\Repositories\ArticleRepository', ['newsApi' => $newsApi]);

        // Construct the news controller
        $ArticleController = app('App\Http\Controllers\ArticleController', ['article' => $ArticleRepository]);

        // Call the news listing
        $view = $ArticleController->show($request);

        // Make sure the news title is the page title
        $this->assertEquals($view->getData()['article']['data']['title'], $view->getData()['page']['title']);
    }

    /**
     * @covers App\Http\Controllers\ArticleController::index
     * @expectedException Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @test
     */
    public function news_listing_with_invalid_topic_should_404()
    {
        // Mock the connector
        $newsApi = Mockery::mock('Waynestate\Api\News');
        $newsApi->shouldReceive('request')->once()->andReturn(['errors' => []]);

        // Construct the repositories
        $articleRepository = app('App\Repositories\ArticleRepository', ['newsApi' => $newsApi]);
        $topicRepository = app('App\Repositories\topicRepository', ['newsApi' => $newsApi]);

        // Construct the news controller
        $ArticleController = app('App\Http\Controllers\ArticleController', ['article' => $articleRepository, 'topic' => $topicRepository]);

        $request = new Request();
        $request->path = '/'.config('base.news_listing_route').'/'.config('base.news_topic_route');
        $request->slug = 'invalid-category';

        // Call the news listing
        $view = $ArticleController->index($request);
    }
}
