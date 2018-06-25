<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class Data
{
    /** @var $prefix **/
    protected $prefix = 'App';

    /**
     * Set a global data array to the request object from repositories that
     * implement the RequestDataRepositoryContract.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (using_styleguide()) {
            $this->prefix = 'Styleguide';
        }

        //Set the matched route parameters to global data
        $data['parameters'] = $request->route() !== null ? $request->route()->parameters : [];

        // If no path was matched from the route parameters, get the path from the request
        if (! isset($data['parameters']['path']) || $data['parameters']['path'] == '') {
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

        // Merge server and page data so global repositories can use them
        $data = merge($data, $page);

        // Merge global repository data and set it to the request
        $request->data = merge(
            $data,
            app($this->getPrefix().'\Repositories\MenuRepository')->getRequestData($data),
            app($this->getPrefix().'\Repositories\PromoGlobalRepository')->getRequestData($data)
        );

        // Controller namespace path so it can be constructed in the routes file
        $request->controller = $this->getControllerNamespace($data['page']['controller']);

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

        return isset($request->any) ? $request->any.$path : $path;
    }
}
