<?php

namespace Tests\Unit\Repositories;

use PHPUnit\Framework\Attributes\Test;
use App\Repositories\TopicRepository;
use Factories\Topic;
use Tests\TestCase;
use Mockery as Mockery;
use Waynestate\Api\News;

final class TopicRepositoryTest extends TestCase
{
    #[Test]
    public function getting_topics_should_return_array_of_topics(): void
    {
        // Fake return
        $return = app(Topic::class)->create(5);

        // Mock the connector and set the return
        $newsApi = Mockery::mock(News::class);
        $newsApi->shouldReceive('request')->andReturn($return);

        $all_topics = [
            'topic_id' => '0',
            'name' => 'All topics',
            'slug' => '',
            'url' => '/',
        ];

        $return = collect($return)->map(function ($item) use ($all_topics) {
            $item = collect($item)->prepend($all_topics);
            return $item;
        })->prepend($all_topics)->toArray();

        $topicRepository = app(TopicRepository::class, ['newsApi' => $newsApi]);

        // Get the articles
        $topics = $topicRepository->listing($this->faker->randomDigit());

        $this->assertCount(count($topics['topics']['data']), $return['data']);
    }

    #[Test]
    public function getting_topics_with_exception_should_return_empty_array(): void
    {
        // Fake return
        $return = app(Topic::class)->create(5);

        // Mock the connector and set the return
        $newsApi = Mockery::mock(News::class);
        $newsApi->shouldReceive('request')->andThrow(new \Exception());

        $topics = app(TopicRepository::class, ['newsApi' => $newsApi])->listing(1);

        $this->assertCount(0, $topics['topics']);
    }

    #[Test]
    public function finding_topic_should_return_topic(): void
    {
        // Fake return
        $return = app(Topic::class)->create(1, true);

        // Mock the connector and set the return
        $newsApi = Mockery::mock(News::class);
        $newsApi->shouldReceive('request')->andReturn($return);

        // Get the news categories
        $topic = app(TopicRepository::class, ['newsApi' => $newsApi])->find($this->faker->word());

        // Make sure they are the same as the ones we created
        $this->assertEquals($return['data']['topic_id'], $topic['topic']['data']['topic_id']);
    }

    #[Test]
    public function sorting_topics_by_letter_should_be_in_order(): void
    {
        // Fake return
        $topics = app(Topic::class)->create(5);

        // Mock the connector and set the return
        $newsApi = Mockery::mock(News::class);

        // Get the news categories
        $sorted = app(TopicRepository::class, ['newsApi' => $newsApi])->sortByLetter($topics['data']);

        foreach ($sorted as $letter => $topics) {
            foreach ($topics as $topic) {
                $this->assertEquals($topic['name'][0], $letter);
            }
        }
    }

    #[Test]
    public function setting_selected_topic(): void
    {
        $topics = app(Topic::class)->create(5);

        $newsApi = Mockery::mock(News::class);

        $first = collect($topics['data'])->first();

        $selected = app(TopicRepository::class, ['newsApi' => $newsApi])->setSelected($topics['data'], $first['slug']);

        $this->assertTrue(collect($selected)->first()['selected']);
    }

    #[Test]
    public function setting_no_selected_topic(): void
    {
        $topics = app(Topic::class)->create(5);

        $newsApi = Mockery::mock(News::class);

        $first = collect($topics['data'])->first();

        $selected = app(TopicRepository::class, ['newsApi' => $newsApi])->setSelected($topics['data'], null);

        $this->assertFalse(collect($selected)->first()['selected']);
    }

    #[Test]
    public function getting_topics_with_exception_should_fall_back_to_last_good_topics(): void
    {
        config(['cache.ttl' => 60]);

        $return = app(Topic::class)->create(5);

        // Mock the News API to succeed once and then fail
        $newsApi = Mockery::mock(News::class);
        $newsApi->shouldReceive('request')->twice()->andReturnUsing(
            fn () => $return,
            fn () => throw new \Exception('API is down')
        );

        $topicRepository = app(TopicRepository::class, ['newsApi' => $newsApi]);

        $topics = $topicRepository->listing(1);

        // Expire the good copy so the next request goes back to the API and fails
        $this->travel(61)->seconds();

        $this->assertNotEmpty($topics['topics']['data']);
        $this->assertEquals($topics, $topicRepository->listing(1));

        $this->travelBack();
    }

    #[Test]
    public function getting_topics_when_news_api_returns_false_should_not_be_cached(): void
    {
        config(['cache.ttl' => 60]);

        $return = app(Topic::class)->create(5);

        // Mock the News API to fail without throwing once and then succeed
        $newsApi = Mockery::mock(News::class);
        $newsApi->shouldReceive('request')->twice()->andReturn(false, $return);

        $topicRepository = app(TopicRepository::class, ['newsApi' => $newsApi]);

        $this->assertEquals(['topics' => []], $topicRepository->listing(1));

        // "All topics" plus the topics from the API
        $this->assertCount(count($return['data']) + 1, $topicRepository->listing(1)['topics']['data']);
    }

    #[Test]
    public function cached_topics_should_use_the_current_subsite_folder(): void
    {
        config(['cache.ttl' => 60]);

        $return = app(Topic::class)->create(1);
        $topic = current($return['data']);

        // The News API should only be called once
        $newsApi = Mockery::mock(News::class);
        $newsApi->shouldReceive('request')->once()->andReturn($return);

        $topicRepository = app(TopicRepository::class, ['newsApi' => $newsApi]);

        $topicRepository->listing(1, 'first/');
        $topics = $topicRepository->listing(1, 'second/');

        $this->assertEquals('/second/'.config('base.news_listing_route'), $topics['topics']['data'][0]['url']);
        $this->assertEquals('/second/'.config('base.news_listing_route').'/'.config('base.news_topic_route').'/'.$topic['slug'], $topics['topics']['data'][1]['url']);
    }

    #[Test]
    public function finding_topic_when_news_api_returns_false_should_not_be_cached(): void
    {
        config(['cache.ttl' => 60]);

        $return = app(Topic::class)->create(1, true);

        $newsApi = Mockery::mock(News::class);
        $newsApi->shouldReceive('request')->twice()->andReturn(false, $return);

        $topicRepository = app(TopicRepository::class, ['newsApi' => $newsApi]);

        $this->assertEquals(['topic' => []], $topicRepository->find('slug'));
        $this->assertEquals($return, $topicRepository->find('slug')['topic']);
    }
}
