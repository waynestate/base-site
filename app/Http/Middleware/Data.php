<?php

namespace App\Http\Middleware;

use Symfony\Component\HttpFoundation\Response;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class Data
{
    /** @var $prefix **/
    protected $prefix = 'App';

    /**
     * Set a global data array to the request object containing page information
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (using_styleguide()) {
            $this->prefix = 'Styleguide';
        }

        //Set the matched route parameters to global data
        $data['parameters'] = $request->route() !== null ? $request->route()->parameters : [];

        // If no path was matched from the route parameters, get the path from the request
        if (empty($data['parameters']['path'])) {
            $data['parameters']['path'] = $this->getPathFromRequest($request);
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
        $data['meta']['image'] = !empty($page['data']['meta_image']) ? $page['data']['meta_image'] : '';
        $data['meta']['image_alt'] = !empty($page['data']['meta_image_alt']) ? $page['data']['meta_image_alt'] : '';
        $page['page']['description'] = !empty($page['data']['page_description']) ? $page['data']['page_description'] : $page['page']['description'];
        $page['page']['title'] = !empty($page['data']['page_title']) ? $page['data']['page_title'] : $page['page']['title'];

        // Merge server and page data so global repositories can use them
        $request->data = merge($data, $page);

        // Get the global data config
        $config = config('base.global');

        // Get the global callbacks
        $callbacks = $config['all']['callbacks'];

        // Merge the callbacks for the site we are on
        if (!empty($config['sites'][$page['site']['id']]['callbacks'])) {
            $callbacks = array_merge($callbacks, $config['sites'][$page['site']['id']]['callbacks']);
        }

        // Get global data
        $global = collect($callbacks)->flatMap(function ($callback) use ($request) {
            list($controller, $method) = Str::parseCallback($callback);

            return app($this->getPrefix().$controller)->$method($request->data);
        })->toArray();

        // Merge global data
        $request->data = merge($request->data, $global);

        // Controller namespace path so it can be constructed in the routes file
        $request->controller = $this->getControllerNamespace($request->data['page']['controller']);

        // Scope the waynestate/base-site global request data to be within ['base']
        // This was found to be an issue with InertiaJS which had it's own $page variable in the view
        if (!empty($request->data)) {
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
     *
     * @param string $controller
     * @return string
     */
    public function getControllerNamespace($controller)
    {
        // First see if it exists as a prefixed controller
        if (class_exists($this->GetPrefix().'\Http\Controllers\\'.$controller)) {
            return $this->GetPrefix().'\Http\Controllers\\'.$controller;
        }

        return 'App\Http\Controllers\\'.$controller;
    }

    /**
     * Get the prefix.
     *
     * @return string
     */
    public function getPrefix()
    {
        return $this->prefix;
    }

    /**
     * Get the path from the request.
     *
     * @param \Illuminate\Http\Request $request
     * @return string
     */
    public function getPathFromRequest(Request $request)
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
                if (! strstr($item, '{')) {
                    return $item;
                }
            })
            ->implode('/');

        return !empty($request->any) ? $request->any.$path : $path;
    }
}
