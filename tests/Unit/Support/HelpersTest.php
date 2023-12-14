<?php

namespace Tests\Unit\Support;

use PHPUnit\Framework\Attributes\Test;
use Illuminate\Support\Str;
use Tests\TestCase;

final class HelpersTest extends TestCase
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

    #[Test]
    public function merge_should_stringify_page_title(): void
    {
        // Default keys
        $pre_merge['base']['site']['title'] = '';
        $pre_merge['base']['site']['subsite-folder'] = '';
        $pre_merge['base']['server']['path'] = '';

        // If there is already a page title, do nothing
        $pre_merge['base']['meta']['title'] = $this->faker->sentence();
        $post_merge = merge($pre_merge);
        $this->assertEquals($pre_merge, $post_merge);
        unset($pre_merge['base']['meta']['title']);

        // If on homepage, do not include page title
        $pre_merge['base']['page']['title'] = $this->faker->word();
        $pre_merge['base']['server']['path'] = '';
        $post_merge = merge($pre_merge);
        $this->assertEquals('Wayne State University', $post_merge['base']['meta']['title']);

        // If on a regular page
        $pre_merge['base']['page']['title'] = $this->faker->word();
        $pre_merge['base']['server']['path'] = '/path';
        $post_merge = merge($pre_merge);
        $this->assertEquals(
            $pre_merge['base']['page']['title'] . ' - Wayne State University',
            $post_merge['base']['meta']['title']
        );

        // If there is a site title
        $pre_merge['base']['page']['title'] = $this->faker->word();
        $pre_merge['base']['site']['title'] = $this->faker->word();
        $post_merge = merge($pre_merge);
        $this->assertEquals(
            $pre_merge['base']['page']['title'] . ' - ' . $pre_merge['base']['site']['title'] . ' - Wayne State University',
            $post_merge['base']['meta']['title']
        );

        // Page title longer than 38 chars, drop the site name
        $pre_merge['base']['page']['title'] = Str::random(40);
        $post_merge = merge($pre_merge);
        $this->assertEquals(
            $pre_merge['base']['page']['title'] . ' - Wayne State University',
            $post_merge['base']['meta']['title']
        );

        // Page title longer than 48 chars, drop Wayne State University
        $pre_merge['base']['page']['title'] = Str::random(50);
        $post_merge = merge($pre_merge);
        $this->assertEquals(
            $pre_merge['base']['page']['title'],
            $post_merge['base']['meta']['title']
        );
    }
}
