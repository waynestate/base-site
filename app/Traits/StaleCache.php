<?php

namespace App\Traits;

use Illuminate\Support\Facades\Log;
use Throwable;

trait StaleCache
{
    /**
     * Cache the result of a callback, falling back to a long-lived stale copy
     * when the callback fails or returns null (API/DB outage), and falling
     * back to $default when no stale copy exists yet (cold start).
     */
    public function rememberWithFallback(string $key, $ttl, callable $callback, $default = [])
    {
        $cached = $this->cache->get($key);

        if ($cached !== null) {
            return $cached;
        }

        $stale_key = 'stale_'.$key;
        $exception = null;

        try {
            $value = $callback();
        } catch (Throwable $e) {
            $exception = $e;
            $value = null;
        }

        if ($value !== null) {
            $this->cache->put($key, $value, $ttl);
            $this->cache->put($stale_key, $value, config('cache.stale_ttl'));

            return $value;
        }

        $stale = $this->cache->get($stale_key);

        Log::warning(sprintf(
            'StaleCache: falling back to %s for cache key [%s]%s',
            $stale !== null ? 'stale data' : 'default (no stale data available)',
            $key,
            $exception !== null ? ' after exception: '.$exception->getMessage() : ' after a null API response'
        ));

        return $stale !== null ? $stale : $default;
    }
}
