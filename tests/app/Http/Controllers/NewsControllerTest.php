<?php

namespace Tests\App\Http\Controllers;

use Tests\TestCase;
use Mockery as Mockery;
use Illuminate\Http\Request;

class NewsControllerTest extends TestCase
{
    /**
     * @covers App\Http\Controllers\NewsController::__construct
     * @covers App\Http\Controllers\NewsController::show
     * @expectedException Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @test
     */
    public function news_view_with_no_item_should_404()
    {
        // Fake return
        $return = [
            'error' => [
                'status' => 101,
            ],
        ];

        // Mock the connector
        $wsuApi = Mockery::mock('Waynestate\Api\Connector');
        $wsuApi->shouldReceive('sendRequest')->with('cms.news.info', Mockery::type('array'))->once()->andReturn($return);

        // Construct the news repository
        $newsRepository = app('App\Repositories\NewsRepository', [$wsuApi]);

        // Construct the news controller
        $newsController = app('App\Http\Controllers\NewsController', [$newsRepository]);

        // Call the news listing
        $view = $newsController->show(new Request(), $this->faker->numberBetween(1, 100));
    }

    /**
     * @covers App\Http\Controllers\NewsController::show
     * @expectedException Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @test
     */
    public function news_item_that_is_not_archived_should_404()
    {
        // Fake return
        $return = [
            'news' => [
                'archive' => 0,
                'ending' => '0000-00-00 00:00:00',
            ],
        ];

        // Mock the connector
        $wsuApi = Mockery::mock('Waynestate\Api\Connector');
        $wsuApi->shouldReceive('sendRequest')->with('cms.news.info', Mockery::type('array'))->once()->andReturn($return);

        // Construct the news repository
        $newsRepository = app('App\Repositories\NewsRepository', [$wsuApi]);

        // Construct the news controller
        $newsController = app('App\Http\Controllers\NewsController', [$newsRepository]);

        // Call the news listing
        $view = $newsController->show(new Request(), $this->faker->numberBetween(1, 100));
    }

    /**
     * @covers App\Http\Controllers\NewsController::show
     * @test
     */
    public function news_item_with_link_should_redirect()
    {
        // Fake return
        $return = [
            'news' => [
                'archive' => 1,
                'link' => $this->faker->url,
            ],
        ];

        // Mock the connector
        $wsuApi = Mockery::mock('Waynestate\Api\Connector');
        $wsuApi->shouldReceive('sendRequest')->with('cms.news.info', Mockery::type('array'))->once()->andReturn($return);

        // Construct the news repository
        $newsRepository = app('App\Repositories\NewsRepository', [$wsuApi]);

        // Construct the news controller
        $newsController = app('App\Http\Controllers\NewsController', [$newsRepository]);

        // Call the news listing
        $redirect = $newsController->show(new Request(), $this->faker->numberBetween(1, 100));

        // Make sure it redirected properly
        $this->assertEquals(302, $redirect->status());
        $this->assertEquals($return['news']['link'], $redirect->getTargetUrl());
    }

    /**
     * @covers App\Http\Controllers\NewsController::show
     * @test
     */
    public function page_title_should_be_news_item_title()
    {
        // Fake return
        $return = [
            'news' => [
                'archive' => 1,
                'link' => '',
                'title' => $this->faker->sentence,
            ],
        ];

        // Fake request
        $request = new Request();
        $request->data = [
            'site' => [
                'id' => 1,
            ],
            'page' => [
                'title' => $this->faker->sentence,
            ],
        ];

        // Mock the connector
        $wsuApi = Mockery::mock('Waynestate\Api\Connector');
        $wsuApi->shouldReceive('sendRequest')->with('cms.news.info', Mockery::type('array'))->once()->andReturn($return);
        $wsuApi->shouldReceive('sendRequest')->with('cms.news.categories', Mockery::type('array'))->once()->andReturn(['news_categories' => []]);

        // Construct the news repository
        $newsRepository = app('App\Repositories\NewsRepository', [$wsuApi]);

        // Construct the news controller
        $newsController = app('App\Http\Controllers\NewsController', [$newsRepository]);

        // Call the news listing
        $view = $newsController->show($request, $this->faker->numberBetween(1, 100));

        // Make sure the news title is the page title
        $this->assertEquals($view->getData()['news']['title'], $view->getData()['page']['title']);
    }

    /**
     * @covers App\Http\Controllers\NewsController::index
     * @expectedException Symfony\Component\HttpKernel\Exception\NotFoundHttpException
     * @test
     */
    public function news_listing_with_invalid_category_should_404()
    {
        // Mock the connector
        $wsuApi = Mockery::mock('Waynestate\Api\Connector');
        $wsuApi->shouldReceive('sendRequest')->with('cms.news.categories', Mockery::type('array'))->once()->andReturn(['news_categories' => []]);

        // Construct the news repository
        $newsRepository = app('App\Repositories\NewsRepository', [$wsuApi]);

        // Construct the news controller
        $newsController = app('App\Http\Controllers\NewsController', [$newsRepository]);

        // Call the news listing
        $view = $newsController->index(new Request(), '/news', 'invalid-category');
    }
}
