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
                    $content = is_string($content) ? stripslashes($content) : $content;

                    return is_string($content) && str_contains($content, '[') ? $this->parser->parse($content) : $content;
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
                $value = stripslashes($value);
                $data[$key] = str_contains($value, '[') ? $this->parser->parse($value) : $value;
            }
        }

        return $data;
    }
}
