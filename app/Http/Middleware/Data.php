<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class Data
{
    protected string $prefix = 'App';

    /**
     * Set a global data array to the request object containing page information
     */
    public function handle(Request $request, Closure $next): ?Response
    {
        if (using_styleguide()) {
            $this->prefix = 'Styleguide';
        }

        // Set the matched route parameters to global data
        $data['parameters'] = $request->route() !== null ? $request->route()->parameters : [];

        // If no path was matched from the route parameters, get the path from the request
        if (empty($data['parameters']['path'])) {
            $data['parameters']['path'] = $this->getPathFromRequest($request);
        }

        if (str_contains($data['parameters']['path'], '.')) {
            return abort(404);
        }


        // Set the current url
        $data['server']['url'] = $request->url();
        $data['server']['url_with_query'] = $request->fullUrl();
        $data['server']['path'] = $request->path();
        $data['server']['path_with_query'] = $request->server->get('REQUEST_URI');

        // Get the page data
        $page = app($this->getPrefix().'\Repositories\PageRepository')->getRequestData($data);

        // If the page is a redirect then return that response
        if ($page instanceof \Illuminate\Http\RedirectResponse) {
            return $page;
        }

        // Overrides for meta information
        $data['meta']['image'] = ! empty($page['data']['meta_image']) ?
            $page['data']['meta_image'] :
            (config('base.global.sites.'.$page['site']['id'].'.meta_image') ?? '');
        $data['meta']['image_alt'] = ! empty($page['data']['meta_image_alt']) ?
            $page['data']['meta_image_alt'] :
            (config('base.global.sites.'.$page['site']['id'].'.meta_image_alt') ?? '');

        $data['meta']['json_ld'] = '';
        if (! empty($page['data']['meta-json-ld'])) {
            $decoded = json_decode($page['data']['meta-json-ld'], true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $data['meta']['json_ld'] = json_encode($decoded, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
            }
        }

        $page['page']['description'] = ! empty($page['data']['page_description']) ? $page['data']['page_description'] : $page['page']['description'];
        $page['page']['title'] = ! empty($page['data']['page_title']) ? $page['data']['page_title'] : $page['page']['title'];

        // Merge server and page data so global repositories can use them
        $request->data = merge($data, $page);

        // Get the site layout and merge
        $layoutName = config('base.layout', 'main');
        $layout['layout'] = View::exists('layouts.' . $layoutName) ? $layoutName : 'main';
        $request->data = merge($request->data, $layout);

        // Determine whether the global header should be shown based on the request
        $request->data['show_header'] = !$request->cookies->has(config('base.exclude_header_cookie'));

        $styleguideSites = (using_styleguide() && config('app.name') === 'base')
            ? $this->getAvailableStyleguideSites()
            : [];
        $previewApp = $this->getStyleguidePreviewApp($request, $styleguideSites);

        // Site-specific additive styles and scripts
        $request->data['site_css'] = $this->getSiteCss($previewApp);
        $request->data['site_js'] = $this->getSiteJs($previewApp);
        $request->data['styleguide_sites'] = $styleguideSites;
        $request->data['styleguide_selected_site'] = $previewApp;

        // Get the global data config
        $config = config('base.global');

        // Get the global callbacks
        $callbacks = $config['all']['callbacks'];

        // Merge the callbacks for the site we are on
        if (! empty($config['sites'][$page['site']['id']]['callbacks'])) {
            $callbacks = array_merge($callbacks, $config['sites'][$page['site']['id']]['callbacks']);
        }

        // Get global data
        $global = collect($callbacks)->flatMap(function ($callback) use ($request) {
            [$controller, $method] = Str::parseCallback($callback);

            return app($this->getPrefix().$controller)->$method($request->data);
        })->toArray();

        // Merge global data
        $request->data = merge($request->data, $global);

        // Controller namespace path so it can be constructed in the routes file
        $request->controller = $this->getControllerNamespace($request->data['page']['controller']);

        // Scope the waynestate/base-site global request data to be within ['base']
        // This was found to be an issue with InertiaJS which had it's own $page variable in the view
        if (! empty($request->data)) {
            $request_keys = array_keys($request->data);

            $request->data['base'] = $request->data;

            foreach ($request_keys as $request_key) {
                unset($request->data[$request_key]);
            }
        }

        return $next($request);
    }

    /**
     * Get the controller namespace.
     */
    public function getControllerNamespace(string $controller): string
    {
        // First see if it exists as a prefixed controller
        if (class_exists($this->GetPrefix().'\Http\Controllers\\'.$controller)) {
            return $this->GetPrefix().'\Http\Controllers\\'.$controller;
        }

        return 'App\Http\Controllers\\'.$controller;
    }

    /**
     * Get the prefix.
     */
    public function getPrefix(): string
    {
        return $this->prefix;
    }

    /**
     * Get the path from the request.
     */
    public function getPathFromRequest(Request $request): string
    {
        // When a request object is created manually that hasn't matched a route (ex: tests).
        if ($request->route() === null) {
            return $request->path();
        }

        // Replace the any route parameter so we can get access to starting route to find the json file
        $uri = str_replace('{any?}', '', $request->route()->uri);

        // Check the route uri and trim off all parts that are route parameters.
        $path = collect(explode('/', $uri))
            ->filter(function ($item) {
                return ! strstr($item, '{');  // Return boolean, not the item
            })
            ->implode('/');

        return ! empty($request->any) ? $request->any.$path : $path;
    }

    /**
     * Get the site-specific CSS file path if it exists in the mix manifest.
     */
    public function getSiteCss(?string $site = null): ?string
    {
        $site = Str::slug($site ?? config('app.name', 'base'));

        if (empty($site) || $site === 'base') {
            return null;
        }

        $manifest = $this->getMixManifest();
        $path = '/_resources/css/'.$site.'.css';

        return isset($manifest[$path]) ? '_resources/css/'.$site.'.css' : null;
    }

    /**
     * Get the site-specific JS file path if it exists in the mix manifest.
     */
    public function getSiteJs(?string $site = null): ?string
    {
        $site = Str::slug($site ?? config('app.name', 'base'));

        if (empty($site) || $site === 'base') {
            return null;
        }

        $manifest = $this->getMixManifest();
        $path = '/_resources/js/'.$site.'.js';

        return isset($manifest[$path]) ? '_resources/js/'.$site.'.js' : null;
    }

    /**
     * Get the mix manifest array.
     */
    public function getMixManifest(?string $path = null): array
    {
        $path = $path ?? public_path('mix-manifest.json');

        if (! file_exists($path)) {
            return [];
        }

        return json_decode((string) file_get_contents($path), true) ?: [];
    }

    /**
     * Get the available custom sites from the mix manifest.
     *
     * @return array<string, string>
     */
    public function getAvailableStyleguideSites(?array $manifest = null): array
    {
        $manifest = $manifest ?? $this->getMixManifest();
        $reserved = ['main', '404', '403', '429', '500'];
        $sites = [];

        foreach (array_keys($manifest) as $path) {
            if (preg_match('#^/_resources/(css|js)/([a-zA-Z0-9_-]+)\.(css|js)$#', $path, $matches)) {
                $site = $matches[2];
                if (! in_array($site, $reserved, true) && ! isset($sites[$site])) {
                    $sites[$site] = Str::headline($site);
                }
            }
        }

        ksort($sites);

        return $sites;
    }

    /**
     * Get the active styleguide preview site name from query param or cookie.
     */
    public function getStyleguidePreviewApp(Request $request, ?array $availableSites = null): ?string
    {
        if (! using_styleguide() || config('app.name') !== 'base') {
            return null;
        }

        $app = $request->query('app', $request->cookie('styleguide_app'));

        if (! is_string($app) || empty($app)) {
            return null;
        }

        $app = Str::slug($app);
        $available = $availableSites ?? $this->getAvailableStyleguideSites();

        return array_key_exists($app, $available) ? $app : null;
    }
}
