<?php

namespace App\Http\Middleware;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Request;
use Closure;
use Waynestate\FormyParser\Parser;

class Formy
{
    /**
     * Construct the middleware.
     */
    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Parse the page content and replace form embeds with form html.
     */
    public function handle(Request $request, Closure $next): Response
    {
        $request->data['base']['page']['content'] = collect($request->data['base']['page']['content'])
            ->map(function ($content) {
                return $this->parser->parse(stripslashes($content));
            })
            ->toArray();

        return $next($request);
    }
}
