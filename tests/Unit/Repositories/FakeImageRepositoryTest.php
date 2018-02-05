<?php

namespace Tests\App\Repositories;

use Tests\TestCase;

class FakeImageRepositoryTest extends TestCase
{
    /**
     * @covers Styleguide\Repositories\FakeImageRepository::dimensions
     * @test
     */
    public function dimensions_should_return_height_and_width()
    {
        $expected = [
            'width' => $this->faker->numberBetween(0, 100),
            'height' => $this->faker->numberBetween(0, 100),
        ];

        $actual = app('Styleguide\Repositories\FakeImageRepository')->dimensions($expected['width'].'x'.$expected['height']);

        $this->assertEquals($expected, $actual);
    }

    /**
     * @covers Styleguide\Repositories\FakeImageRepository::reasonableSize
     * @test
     */
    public function image_should_be_reasonable_size()
    {
        $reasonable = app('Styleguide\Repositories\FakeImageRepository')->reasonableSize([
            'width' => $this->faker->numberBetween(0, 100),
            'height' => $this->faker->numberBetween(0, 100),
        ]);

        $notReasonable = app('Styleguide\Repositories\FakeImageRepository')->reasonableSize([
            'width' => $this->faker->numberBetween(4000, 5000),
            'height' => $this->faker->numberBetween(4000, 5000),
        ]);

        $this->assertTrue($reasonable);
        $this->assertFalse($notReasonable);
    }

    /**
    * @covers Styleguide\Repositories\FakeImageRepository::create
    * @test
    */
    public function creating_image_should()
    {
        $width = $this->faker->numberBetween(0, 100);
        $height = $this->faker->numberBetween(0, 100);

        $image = app('Styleguide\Repositories\FakeImageRepository')->create($width, $height);

        $this->assertEquals($width, imagesx($image));
        $this->assertEquals($height, imagesy($image));
    }
}
