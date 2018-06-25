<?php

namespace App\Http\Middleware;

use Closure;
use Waynestate\FormyParser\Parser;

class Formy
{
    /**
     * Construct the middleware.
     *
     * @param Parser $parser
     */
    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Parse the page content and replace form embeds with form html.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request->data['page']['content'] = collect($request->data['page']['content'])
            ->map(function ($content) {
                return $this->parser->parse(stripslashes($content));
            })
            ->toArray();

        return $next($request);
    }
}
