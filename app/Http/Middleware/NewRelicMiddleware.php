<?php

namespace App\Http\Middleware;

use Closure;

class NewRelicMiddleware
{
    /**
     * Track transactions in newrelic.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        // Load the newrelic transaction
        if (extension_loaded('newrelic')) {
            // Transaction name without GET params
            newrelic_name_transaction($request->server->get('REDIRECT_URL'));

            // Track GET params separately
            foreach ((array) $request->query() as $key => $value) {
                newrelic_add_custom_parameter($key, $value);
            }
        }

        return $next($request);
    }
}
