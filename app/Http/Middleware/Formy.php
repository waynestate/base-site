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
     * Structural and metadata keys that never contain user form embeds.
     */
    protected array $ignoredKeys = [
        'server' => true,
        'parameters' => true,
        'site' => true,
        'menu' => true,
        'meta' => true,
        'layout' => true,
        'layout_config' => true,
        'page_config' => true,
        'site_menu' => true,
        'site_menu_output' => true,
        'top_menu' => true,
        'top_menu_output' => true,
        'breadcrumbs' => true,
        'show_header' => true,
        'show_site_menu' => true,
    ];

    /**
     * Construct the middleware.
     */
    public function __construct(Parser $parser)
    {
        $this->parser = $parser;
    }

    /**
     * Parse the page content, promotion descriptions, and excerpts to replace form embeds with form html.
     */
    public function handle(Request $request, Closure $next): ?Response
    {
        if (!empty($request->data['base']['page']['content']) && is_array($request->data['base']['page']['content'])) {
            foreach ($request->data['base']['page']['content'] as $key => $content) {
                if (is_string($content)) {
                    $request->data['base']['page']['content'][$key] = $this->parseString($content);
                }
            }
        }

        if (!empty($request->data['base'])) {
            $request->data['base'] = $this->parseContent($request->data['base']);
        }

        return $next($request);
    }

    /**
     * Parse content fields (description and excerpt) in targeted arrays.
     */
    public function parseContent(array $data): array
    {
        foreach ($data as $key => $value) {
            if (isset($this->ignoredKeys[$key])) {
                continue;
            }

            if (is_array($value)) {
                $data[$key] = $this->parseContent($value);
            } elseif (($key === 'description' || $key === 'excerpt') && is_string($value)) {
                $data[$key] = $this->parseString($value);
            }
        }

        return $data;
    }

    /**
     * Parse a single string for form embeds after stripping slashes.
     */
    public function parseString(string $value): string
    {
        if (!str_contains($value, '\\') && !str_contains($value, '[')) {
            return $value;
        }

        $value = stripslashes($value);

        return str_contains($value, '[') ? $this->parser->parse($value) : $value;
    }
}
