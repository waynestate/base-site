<?php

namespace App\Http\Middleware;

use Closure;

class TrustedProxyMiddleware
{
    /**
     * Set the current servers ip address as a trusted proxy so we can
     * resolve the users ip address.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request->setTrustedProxies([$request->server->get('REMOTE_ADDR')]);

        return $next($request);
    }
}
