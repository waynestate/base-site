<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Waynestate\FormyParser\Parser;

class Formy
{
    protected Parser $parser;

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
    public function handle(Request $request, Closure $next): ?Response
    {
        $request->data['base']['page']['content'] = collect($request->data['base']['page']['content'])
            ->map(function ($content) {
                return $this->parser->parse(stripslashes($content));
            })
            ->toArray();

        return $next($request);
    }
}
