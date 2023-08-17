<?php

namespace Tests\Unit\Support;

use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class HelpersTest extends TestCase
{
    #[Test]
    public function merge_string_value_should_throw_exception(): void
    {
        $this->expectException(\Exception::class);

        $merge = merge($this->faker->word());
    }

    #[Test]
    public function merge_array_with_zero_key_should_throw_exception(): void
    {
        $this->expectException(\Exception::class);

        $merge = merge([$this->faker->word()]);
    }

    #[Test]
    public function merge_array_with_same_key_should_throw_exception(): void
    {
        $this->expectException(\Exception::class);

        // Same key to be used
        $key = $this->faker->word();

        merge([$key => $this->faker->sentence()], [$key => $this->faker->sentence()]);
    }

    #[Test]
    public function merge_should_merge_arrays(): void
    {
        // Not using faker for the off chance of generating the same key twice
        $merge = merge(['test1' => 'Test1'], ['test2' => 'Test2']);

        $this->assertEquals(['test1' => 'Test1', 'test2' => 'Test2'], $merge);
    }
}
