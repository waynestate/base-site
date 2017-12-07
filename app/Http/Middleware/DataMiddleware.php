<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Storage;

class DataMiddleware
{
    /** @var $prefix **/
    protected $prefix = 'App';

    /**
     * Set a global data array to the request object from repositories that
     * implement the DataRepositoryContract.
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

        /*
         * Set the route parameters to global data. These parameters are everything
         * that was matched and captured from the routes file.
         */
        $data['parameters'] = $request->route() !== null ? $request->route()->parameters : [];

        /*
         * If no path was matched then set the path to the current relative
         * url from the request. This is necessary when a request object is created
         * manually that hasn't matched a route yet (ex: tests). The path is
         * used later to determine the page data and will 404 if the path
         * isn't translated to a valid json file in the public folder.
         */
        if (! isset($data['parameters']['path']) || $data['parameters']['path'] == '') {
            $data['parameters']['path'] = $request->path();
        }

        // Set the current url
        $data['server']['url'] = $request->url();
        $data['server']['url_with_query'] = $request->fullUrl();
        $data['server']['path'] = $request->path();
        $data['server']['path_with_query'] = $request->server->get('REQUEST_URI');

        // Get the page data
        $pageData = app($this->getPrefix().'\Repositories\PageRepository')->getRequestData($data);

        // If the page is a redirect then return that response
        if ($pageData instanceof \Illuminate\Http\RedirectResponse) {
            return $pageData;
        }

        // Merge all data and page data
        $data = merge($pageData, $data);

        // Controller namespace path so it can be constructed in the routes file
        $request->controller = $this->getControllerNamespace($data['page']['controller']);

        // Create a global data variable that houses repository data that is passed down to every controller
        $data = collect(Storage::disk('base')->allFiles('app/Repositories'))
            ->reject(function ($filename) {
                return in_array(basename($filename), ['PageRepository.php']);
            })
            ->flatMap(function ($filename) use ($data) {
                // Construct the object
                $repository = app($this->getPrefix().'\Repositories\\'.basename($filename, '.php'));

                // Get the data from the repository only if it implements the contract to do so
                if (in_array('Contracts\Repositories\DataRepositoryContract', class_implements($repository))) {
                    $repositoryData = $repository->getRequestData($data);

                    // Merge the data so it exists in one array for the view
                    $data = merge($data, $repositoryData);
                }

                return $data;
            })
            ->toArray();

        // Set the data to the request object so it gets injected into the controller
        $request->data = $data;

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
}
