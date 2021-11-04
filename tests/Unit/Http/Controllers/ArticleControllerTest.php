<?php

namespace Tests\Unit\Http\Controllers;

use Tests\TestCase;
use Mockery as Mockery;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class ArticleControllerTest extends TestCase
{
    /**
     * @covers App\Http\Controllers\ArticleController::__construct
     * @covers App\Http\Controllers\ArticleController::show
     * @test
     */
    public function news_view_with_no_item_should_404()
    {
        $this->expectException(NotFoundHttpException::class);

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
     * @test
     */
    public function news_item_that_is_not_published_should_404()
    {
        $this->expectException(NotFoundHttpException::class);

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
    public function news_item_that_is_draft_should_allow_preview()
    {
        // Fake return
        $return =  app('Factories\Article')->create(1, true, [
            'status' => 'draft',
        ]);

        // Mock the connector
        $newsApi = Mockery::mock('Waynestate\Api\News');
        $newsApi->shouldReceive('request')->andReturn($return);

        // Construct the news repository
        $articleRepository = app('App\Repositories\ArticleRepository', ['newsApi' => $newsApi]);

        // Construct the news controller
        $articleController = app('App\Http\Controllers\ArticleController', ['article' => $articleRepository]);

        $request = new Request();
        $base['base'] = app('Styleguide\Pages\News')->getPageData();
        $request->data = $base;
        $request->preview = true;

        // Call the news listing
        $view = $articleController->show($request);

        $this->assertEquals($return, $view->getData()['article']);
    }

    /**
     * @covers App\Http\Controllers\ArticleController::show
     * @test
     */
    public function news_item_that_is_published_and_preview_should_redirect()
    {
        // Fake return
        $return =  null;

        // Mock the connector
        $newsApi = Mockery::mock('Waynestate\Api\News');
        $newsApi->shouldReceive('request')->andReturn($return);

        // Construct the news repository
        $articleRepository = app('App\Repositories\ArticleRepository', ['newsApi' => $newsApi]);

        // Construct the news controller
        $articleController = app('App\Http\Controllers\ArticleController', ['article' => $articleRepository]);

        $request = new Request();
        $base['base'] = app('Styleguide\Pages\News')->getPageData();
        $request->data = $base;
        $request->preview = true;

        // Call the news listing
        $view = $articleController->show($request);

        $this->assertInstanceOf('Illuminate\Routing\Redirector', $view);
    }

    /**
     * @covers App\Http\Controllers\ArticleController::show
     * @test
     */
    public function page_title_should_be_news_item_title()
    {
        // Fake return
        $return = app('Factories\Article')->create(1, true);

        // Fake request
        $request = new Request();
        $base['base'] = app('Styleguide\Pages\News')->getPageData();
        $request->data = $base;

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
        $this->assertEquals($view->getData()['article']['data']['title'], $view->getData()['base']['page']['title']);
    }

    /**
     * @covers App\Http\Controllers\ArticleController::index
     * @test
     */
    public function news_listing_with_invalid_topic_should_404()
    {
        $this->expectException(NotFoundHttpException::class);

        $newsApi = Mockery::mock('Waynestate\Api\News');
        $articleRepository = app('App\Repositories\ArticleRepository', ['newsApi' => $newsApi]);

        $newsApi = Mockery::mock('Waynestate\Api\News');
        $newsApi->shouldReceive('request')->once()->andReturn(app('Factories\Topic')->create(5));
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
