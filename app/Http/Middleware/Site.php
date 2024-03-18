<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class Site
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(parse_url(config('app.url'), PHP_URL_HOST) != $request->getHost()) {
            if(!preg_match('/(?:www-dev)?([a-z-]+)\.wayne.*$/', $request->getHost(), $hostMatch)) {
                return abort(404);
            }
        }

        return $next($request);
    }
}
