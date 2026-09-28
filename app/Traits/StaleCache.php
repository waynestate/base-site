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

        // If found in cache and not an error, return it
        if ($cached !== null && !array_key_exists('error', (array)$cached)) {
            return $cached;
        }

        $stale_key = 'stale_'.$key;
        $exception = null;

        // If not found in cache, call the callback to get a fresh response
        try {
            $value = $callback();
        } catch (Throwable $e) {
            $exception = $e;
            $value = null;
        }

        // If the callback returned a valid response, cache it short and long-term then return it
        if ($value !== null && !array_key_exists('error', (array)$value)) {
            $this->cache->put($key, $value, $ttl);
            $this->cache->put($stale_key, $value, config('cache.stale_ttl'));

            return $value;
        }

        // If the callback returns null or an error, check the stale copy if it exists
        $stale = $this->cache->get($stale_key);

        Log::warning(sprintf(
            'StaleCache: falling back to %s for cache key [%s]%s',
            $stale !== null ? 'stale data' : 'default (no stale data available)',
            $key,
            $exception !== null ? ' after exception: '.$exception->getMessage() : ' after a null or error API response'
        ));

        // When falling back to stale data, set a shorter-lived backoff cache key to prevent hammering the API on subsequent requests
        if ($stale !== null) {
            $backoff = (int) ($ttl / 2);
            if ($backoff > 0) {
                $this->cache->put($key, $stale, $backoff);
            }

            return $stale;
        }

        return $default;
    }
}
