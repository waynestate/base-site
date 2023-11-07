<?php

namespace Tests\Unit\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use PHPUnit\Framework\Attributes\Test;
use App\Http\Controllers\ArticleController;
use App\Repositories\ArticleRepository;
use App\Repositories\TopicRepository;
use Factories\ApiError;
use Factories\Article;
use Factories\Topic;
use Illuminate\Routing\Redirector;
use Styleguide\Pages\News as StyleguideNews;
use Tests\TestCase;
use Mockery as Mockery;
use Illuminate\Http\Request;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Waynestate\Api\News;

final class ArticleControllerTest extends TestCase
{
    #[Test]
    public function news_view_with_no_item_should_404(): void
    {
        $this->expectException(NotFoundHttpException::class);

        // Fake return
        $return = app(ApiError::class)->create(1, true);

        // Mock the connector
        $newsApi = Mockery::mock(News::class);
        $newsApi->shouldReceive('request')->andReturn($return);

        // Construct the news repository
        $articleRepository = app(ArticleRepository::class, ['newsApi' => $newsApi]);

        // Construct the news controller
        $articleController = app(ArticleController::class, ['article' => $articleRepository]);

        // Call the news listing
        $view = $articleController->show(new Request());
    }

    #[Test]
    public function news_item_that_is_not_published_should_404(): void
    {
        $this->expectException(NotFoundHttpException::class);

        // Fake return
        $return = [
            'news' => app(Article::class)->create(1, true, [
                'status' => 'draft',
            ]),
        ];

        // Mock the connector
        $newsApi = Mockery::mock(News::class);
        $newsApi->shouldReceive('request')->andReturn($return);

        // Construct the news repository
        $articleRepository = app(ArticleRepository::class, ['newsApi' => $newsApi]);

        // Construct the news controller
        $articleController = app(ArticleController::class, ['article' => $articleRepository]);

        $request = new Request();
        $request->data = [
            'base' => [
                'site' => [
                    'news' => [
                        'application_id' => 1,
                    ],
                    'subsite-folder' => null,
                ],
            ],
        ];

        // Call the news listing
        $view = $articleController->show($request);
    }

    #[Test]
    public function news_item_that_is_draft_should_allow_preview(): void
    {
        // Fake return
        $return =  app(Article::class)->create(1, true, [
            'status' => 'draft',
        ]);

        // Mock the connector
        $newsApi = Mockery::mock(News::class);
        $newsApi->shouldReceive('request')->andReturn($return);

        // Construct the news repository
        $articleRepository = app(ArticleRepository::class, ['newsApi' => $newsApi]);

        // Construct the news controller
        $articleController = app(ArticleController::class, ['article' => $articleRepository]);

        $request = new Request();
        $base['base'] = app(StyleguideNews::class)->getPageData();
        $request->data = $base;
        $request->preview = true;

        // Call the news listing
        $view = $articleController->show($request);

        $this->assertEquals($return, $view->getData()['article']);
    }

    #[Test]
    public function news_item_that_is_published_and_preview_should_redirect(): void
    {
        // Fake return
        $return =  null;

        // Mock the connector
        $newsApi = Mockery::mock(News::class);
        $newsApi->shouldReceive('request')->andReturn($return);

        // Construct the news repository
        $articleRepository = app(ArticleRepository::class, ['newsApi' => $newsApi]);

        // Construct the news controller
        $articleController = app(ArticleController::class, ['article' => $articleRepository]);

        $request = new Request();
        $base['base'] = app(StyleguideNews::class)->getPageData();
        $request->data = $base;
        $request->preview = true;

        // Call the news listing
        $view = $articleController->show($request);

        $this->assertInstanceOf(Redirector::class, $view);
    }

    #[Test]
    public function news_item_with_external_link_should_redirect_to_link(): void
    {
        // Fake return
        $return = app(Article::class)->create(1, true, [
            'link' => 'https://today.wayne.edu',
        ]);

        // Mock the connector
        $newsApi = Mockery::mock(News::class);
        $newsApi->shouldReceive('request')->andReturn($return);

        // Construct the news repository
        $articleRepository = app(ArticleRepository::class, ['newsApi' => $newsApi]);

        // Construct the news controller
        $articleController = app(ArticleController::class, ['article' => $articleRepository]);

        $request = new Request();
        $base['base'] = app(StyleguideNews::class)->getPageData();
        $request->data = $base;
        $request->preview = true;

        // Call the news listing
        $view = $articleController->show($request);

        $this->assertInstanceOf(RedirectResponse::class, $view);
    }

    #[Test]
    public function page_title_should_be_news_item_title(): void
    {
        // Fake return
        $return = app(Article::class)->create(1, true);

        // Fake request
        $request = new Request();
        $base['base'] = app(StyleguideNews::class)->getPageData();
        $request->data = $base;

        // Mock the connector
        $newsApi = Mockery::mock(News::class);
        $newsApi->shouldReceive('request')->andReturn($return);

        // Construct the news repository
        $ArticleRepository = app(ArticleRepository::class, ['newsApi' => $newsApi]);

        // Construct the news controller
        $ArticleController = app(ArticleController::class, ['article' => $ArticleRepository]);

        // Call the news listing
        $view = $ArticleController->show($request);

        // Make sure the news title is the page title
        $this->assertEquals($view->getData()['article']['data']['title'], $view->getData()['base']['page']['title']);
    }

    #[Test]
    public function news_listing_with_invalid_topic_should_404(): void
    {
        $this->expectException(NotFoundHttpException::class);

        $newsApi = Mockery::mock(News::class);
        $articleRepository = app(ArticleRepository::class, ['newsApi' => $newsApi]);

        $newsApi = Mockery::mock(News::class);
        $newsApi->shouldReceive('request')->once()->andReturn(app(Topic::class)->create(5));
        $topicRepository = app(TopicRepository::class, ['newsApi' => $newsApi]);

        // Construct the news controller
        $ArticleController = app(ArticleController::class, ['article' => $articleRepository, 'topic' => $topicRepository]);

        $request = new Request();
        $request->path = '/'.config('base.news_listing_route').'/'.config('base.news_topic_route');
        $request->slug = 'invalid-category';
        $request->data = [
            'base' => [
                'site' => [
                    'news' => [
                        'application_id' => 1,
                    ],
                    'subsite-folder' => null,
                ],
            ],
        ];

        // Call the news listing
        $view = $ArticleController->index($request);
    }
}
