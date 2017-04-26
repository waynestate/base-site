<?php

namespace Tests\App\Support;

use Tests\TestCase;

class HelpersTest extends TestCase
{
    /**
     * @covers ::merge
     * @expectedException Exception
     * @test
     */
    public function merge_string_value_should_throw_exception()
    {
        $merge = merge($this->faker->word);
    }

    /**
     * @covers ::merge
     * @expectedException Exception
     * @test
     */
    public function merge_array_with_zero_key_should_throw_exception()
    {
        $merge = merge([$this->faker->word]);
    }

    /**
     * @covers ::merge
     * @expectedException Exception
     * @test
     */
    public function merge_array_with_same_key_should_throw_exception()
    {
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

    /**
     * @covers ::elixir
     * @test
     */
    public function elixir_should_return_resources_path()
    {
        $this->assertEquals('/_resources', elixir(''));
    }

    /**
     * @expectedException InvalidArgumentException
     * @covers ::elixir
     * @test
     */
    public function elixir_should_throw_exception_for_invalid_file()
    {
        $elixir = elixir($this->faker->word);
    }

    /**
     * @covers ::elixir
     * @test
     */
    public function exlir_should_set_manifest_path()
    {
        $buildDirectory = 'build-foo';
        $directory = 'public/'.$buildDirectory.'/';

        // Create a temp build file
        mkdir($directory);
        file_put_contents($directory.'rev-manifest.json', '{"test.css" : "test-123.css"}');
        file_put_contents($directory.'test-123.css', '');

        // Check it against that file
        $elixir = elixir('test.css', $buildDirectory);

        // Clean up
        unlink($directory.'rev-manifest.json');
        unlink($directory.'test-123.css');
        rmdir($directory);

        $this->assertEquals('/'.$buildDirectory.'/test-123.css', $elixir);
    }
}
