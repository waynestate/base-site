<?php

namespace Tests\App\Repositories;

use Tests\TestCase;
use Mockery as Mockery;

class TopicRepositoryTest extends TestCase
{
    /**
     * @covers App\Repositories\TopicRepository::listing
     * @test
     */
    public function getting_topics_should_return_array_of_topics()
    {
        // Fake return
        $return = app('Factories\Topic')->create(5);

        // Mock the connector and set the return
        $newsApi = Mockery::mock('Waynestate\Api\News');
        $newsApi->shouldReceive('request')->andReturn($return);

        $topicRepository = app('App\Repositories\TopicRepository', ['newsApi' => $newsApi]);

        // Get the articles
        $topics = $topicRepository->listing($this->faker->randomDigit);

        $this->assertCount(count($topics['topics']['data']), $return['data']);
    }

    /**
     * @covers App\Repositories\TopicRepository::find
     * @test
     */
    public function finding_topic_should_return_topic()
    {
        // Fake return
        $return = app('Factories\Topic')->create(1, true);

        // Mock the connector and set the return
        $newsApi = Mockery::mock('Waynestate\Api\News');
        $newsApi->shouldReceive('request')->andReturn($return);

        // Get the news categories
        $topic = app('App\Repositories\TopicRepository', ['newsApi' => $newsApi])->find($this->faker->word);

        // Make sure they are the same as the ones we created
        $this->assertEquals($return['data']['topic_id'], $topic['topic']['data']['topic_id']);
    }

    /**
     * @covers App\Repositories\TopicRepository::sortByLetter
     * @test
     */
    public function sorting_topics_by_letter_should_be_in_order()
    {
        // Fake return
        $topics = app('Factories\Topic')->create(5);

        // Mock the connector and set the return
        $newsApi = Mockery::mock('Waynestate\Api\News');

        // Get the news categories
        $sorted = app('App\Repositories\TopicRepository', ['newsApi' => $newsApi])->sortByLetter($topics['data']);

        foreach ($sorted as $letter=>$topics) {
            foreach ($topics as $topic) {
                $this->assertEquals($topic['name'][0], $letter);
            }
        }
    }
}
