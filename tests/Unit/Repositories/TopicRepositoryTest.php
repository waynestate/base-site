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
}
