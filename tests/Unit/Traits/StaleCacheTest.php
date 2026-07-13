<?php

namespace Tests\Unit\Traits;

use App\Traits\StaleCache;
use Illuminate\Cache\Repository;
use Illuminate\Support\Facades\Log;
use PHPUnit\Framework\Attributes\Test;
use RuntimeException;
use Tests\TestCase;

final class StaleCacheTest extends TestCase
{
    private function subject(): object
    {
        return new class (app(Repository::class)) {
            use StaleCache;

            public $cache;

            public function __construct(Repository $cache)
            {
                $this->cache = $cache;
            }
        };
    }

    #[Test]
    public function callback_success_populates_primary_and_stale_cache(): void
    {
        $key = 'test-key-'.$this->faker->uuid();
        $value = ['data' => $this->faker->word()];

        $result = $this->subject()->rememberWithFallback($key, 60, function () use ($value) {
            return $value;
        });

        $this->assertEquals($value, $result);
        $this->assertEquals($value, app(Repository::class)->get($key));
        $this->assertEquals($value, app(Repository::class)->get('stale_'.$key));
    }

    #[Test]
    public function primary_cache_hit_does_not_invoke_callback(): void
    {
        $key = 'test-key-'.$this->faker->uuid();
        $value = ['data' => $this->faker->word()];

        app(Repository::class)->put($key, $value, 60);

        $invoked = false;

        $result = $this->subject()->rememberWithFallback($key, 60, function () use ($value, &$invoked) {
            $invoked = true;

            return $value;
        });

        $this->assertEquals($value, $result);
        $this->assertFalse($invoked);
    }

    #[Test]
    public function callback_throwing_falls_back_to_stale_data_and_logs(): void
    {
        $key = 'test-key-'.$this->faker->uuid();
        $stale_value = ['data' => $this->faker->word()];

        app(Repository::class)->put('stale_'.$key, $stale_value, 604800);

        Log::shouldReceive('warning')->once();

        $result = $this->subject()->rememberWithFallback($key, 60, function () {
            throw new RuntimeException('API is down');
        });

        $this->assertEquals($stale_value, $result);
    }

    #[Test]
    public function callback_returning_null_falls_back_to_stale_data_and_logs(): void
    {
        // This is the total-outage path: vendor Connector::sendRequest() swallows
        // failures and returns null rather than throwing.
        $key = 'test-key-'.$this->faker->uuid();
        $stale_value = ['data' => $this->faker->word()];

        app(Repository::class)->put('stale_'.$key, $stale_value, 604800);

        Log::shouldReceive('warning')->once();

        $result = $this->subject()->rememberWithFallback($key, 60, function () {
            return null;
        });

        $this->assertEquals($stale_value, $result);
    }

    #[Test]
    public function callback_throwing_with_no_stale_data_returns_default_and_logs(): void
    {
        $key = 'test-key-'.$this->faker->uuid();

        Log::shouldReceive('warning')->once();

        $result = $this->subject()->rememberWithFallback($key, 60, function () {
            throw new RuntimeException('API is down');
        });

        $this->assertEquals([], $result);
    }

    #[Test]
    public function callback_returning_null_with_no_stale_data_returns_custom_default_and_logs(): void
    {
        $key = 'test-key-'.$this->faker->uuid();
        $default = ['fallback' => true];

        Log::shouldReceive('warning')->once();

        $result = $this->subject()->rememberWithFallback($key, 60, function () {
            return null;
        }, $default);

        $this->assertEquals($default, $result);
    }
}
