<?php

namespace Tests\App\Support;

use Tests\TestCase;

class HelpersTest extends TestCase
{
    /**
     * @covers ::merge
     * @test
     */
    public function merge_string_value_should_throw_exception()
    {
        $this->expectException(\Exception::class);

        $merge = merge($this->faker->word);
    }

    /**
     * @covers ::merge
     * @test
     */
    public function merge_array_with_zero_key_should_throw_exception()
    {
        $this->expectException(\Exception::class);

        $merge = merge([$this->faker->word]);
    }

    /**
     * @covers ::merge
     * @test
     */
    public function merge_array_with_same_key_should_throw_exception()
    {
        $this->expectException(\Exception::class);

        // Same key to be used
        $key = $this->faker->word;

        merge([$key => $this->faker->sentence], [$key => $this->faker->sentence]);
    }

    /**
     * @covers ::merge
     * @test
     */
    public function merge_should_merge_arrays()
    {
        // Not using faker for the off chance of generating the same key twice
        $merge = merge(['test1' => 'Test1'], ['test2' => 'Test2']);

        $this->assertEquals(['test1' => 'Test1', 'test2' => 'Test2'], $merge);
    }
}
