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
        if (!empty($request->data['base']['page']['content'])) {
            $request->data['base']['page']['content'] = collect($request->data['base']['page']['content'])
                ->map(function ($content) {
                    return $this->parser->parse(stripslashes($content));
                })
                ->toArray();
        }

        if (!empty($request->data['base'])) {
            $request->data['base'] = $this->parseDescriptions($request->data['base']);
        }

        return $next($request);
    }

    /**
     * Recursively parse the description fields.
     */
    public function parseDescriptions(array $data): array
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $this->parseDescriptions($value);
            } elseif ($key === 'description' && is_string($value)) {
                $data[$key] = $this->parser->parse(stripslashes($value));
            }
        }

        return $data;
    }
}
