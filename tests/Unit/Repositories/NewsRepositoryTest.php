<?php

namespace Tests\App\Repositories;

use Tests\TestCase;
use Mockery as Mockery;

class NewsRepositoryTest extends TestCase
{
    /**
     * @covers App\Repositories\NewsRepository::__construct
     * @covers App\Repositories\NewsRepository::getPaging
     * @test
     */
    public function news_paging_should_have_proper_next_and_previous_values()
    {
        // Get a random starting page
        $randomPage = $this->faker->numberBetween(1, 100);

        // Get the paging
        $paging = app('App\Repositories\NewsRepository')->getPaging($randomPage);

        // Check page numbers
        $this->assertEquals($randomPage + 1, $paging['paging']['page_number_previous']);
        $this->assertEquals($randomPage - 1, $paging['paging']['page_number_next']);
    }

    /**
     * @covers App\Repositories\NewsRepository::setSelectedCategory
     * @test
     */
    public function setting_categories_with_correct_slug_should_set_active_category()
    {
        $categories['news_categories'] = app('Factories\NewsCategory')->create(5);

        $slug = $categories['news_categories'][1]['slug'];

        $categories = app('App\Repositories\NewsRepository')->setSelectedCategory($categories, $slug);

        $this->assertEquals($slug, $categories['selected_news_category']['slug']);
    }

    /**
     * @covers App\Repositories\NewsRepository::setSelectedCategory
     * @test
     */
    public function setting_categories_with_invalid_slug_should_return_no_active_category()
    {
        $categories['news_categories'] = app('Factories\NewsCategory')->create(5);

        $categories = app('App\Repositories\NewsRepository')->setSelectedCategory($categories, 'invalid-slug');

        $this->assertEquals(['category_id' => null], $categories['selected_news_category']);
    }

    /**
     * @covers App\Repositories\NewsRepository::getCategories
     * @test
     */
    public function getting_news_categories_should_return_news_categories()
    {
        // Fake return
        $return = [
            'results' => app('Factories\NewsCategory')->create(5),
        ];

        // Mock the connector and set the return
        $wsuApi = Mockery::mock('Waynestate\Api\Connector');
        $wsuApi->shouldReceive('sendRequest')->with('cms.news.categories', Mockery::type('array'))->once()->andReturn($return);

        // Get the news categories
        $categories = app('App\Repositories\NewsRepository', ['wsuApi' => $wsuApi])->getCategories($this->faker->randomDigit);

        // Make sure they are the same as the ones we created
        $this->assertEquals($return, $categories);
    }

    /**
     * @covers App\Repositories\NewsRepository::getNewsItem
     * @test
     */
    public function getting_news_item_should_return_news_item()
    {
        // Fake return
        $return = [
            'news' => app('Factories\NewsItem')->create(1, true),
        ];

        // Mock the connector and set the return
        $wsuApi = Mockery::mock('Waynestate\Api\Connector');
        $wsuApi->shouldReceive('sendRequest')->with('cms.news.info', Mockery::type('array'))->once()->andReturn($return);

        // Get the news categories
        $news = app('App\Repositories\NewsRepository', ['wsuApi' => $wsuApi])->getNewsItem($this->faker->randomDigit, $this->faker->randomDigit);

        // Make sure they are the same as the ones we created
        $this->assertEquals($return, $news);
    }

    /**
     * @covers App\Repositories\NewsRepository::getNewsByDisplayOrder
     * @test
     */
    public function getting_news_by_display_order_with_api_error_should_return_array()
    {
        // Fake return
        $return = app('Factories\ApiError')->create(1, true);

        // Mock the connector and set the return
        $wsuApi = Mockery::mock('Waynestate\Api\Connector');
        $wsuApi->shouldReceive('sendRequest')->with('cms.news.listing', Mockery::type('array'))->once()->andReturn($return);

        // Get the news
        $news = app('App\Repositories\NewsRepository', ['wsuApi' => $wsuApi])->getNewsByDisplayOrder($this->faker->randomDigit);

        // Make sure we have a blank news array
        $this->assertEquals($news, ['news' => []]);
    }

    /**
     * @covers App\Repositories\NewsRepository::getNewsByPage
     * @test
     */
    public function getting_news_by_page_should_return_array_of_news()
    {
        // Fake return
        $return = [
            'news' => app('Factories\NewsItem')->create(5),
        ];

        // Mock the connector and set the return
        $wsuApi = Mockery::mock('Waynestate\Api\Connector');
        $wsuApi->shouldReceive('sendRequest')->with('cms.news.listing', Mockery::type('array'))->once()->andReturn($return);

        // Get the news
        $news = app('App\Repositories\NewsRepository', ['wsuApi' => $wsuApi])->getNewsByPage($this->faker->randomDigit);

        $this->assertEquals($return, $news);
    }

    /**
     * @covers App\Repositories\NewsRepository::getImageUrl
     * @test
     */
    public function news_item_with_no_images_should_return_null()
    {
        $news['news']['filename'] = '';

        $imageUrl = app('App\Repositories\NewsRepository')->getImageUrl($news);

        $this->assertNull($imageUrl);
    }

    /**
     * @covers App\Repositories\NewsRepository::getImageUrl
     * @test
     */
    public function news_item_with_image_should_return_image()
    {
        $news['news']['filename'] = $this->faker->imageUrl();

        $imageUrl = app('App\Repositories\NewsRepository')->getImageUrl($news);

        $this->assertEquals($news['news']['filename'], $imageUrl);
    }

    /**
     * @covers App\Repositories\NewsRepository::getImageUrl
     * @test
     */
    public function news_item_with_body_image_should_return_image()
    {
        $image = $this->faker->imageUrl();

        $news['news']['body'] = '<img src="'.$image.'">';

        $imageUrl = app('App\Repositories\NewsRepository')->getImageUrl($news);

        $this->assertEquals($image, $imageUrl);
    }
}
