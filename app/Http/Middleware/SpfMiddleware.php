<?php

namespace App\Http\Middleware;

use Closure;

class SpfMiddleware
{
    /**
     * Create and return a json response based on the route.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @param string $method
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function handle($request, Closure $next, $method = 'index')
    {
        if ($request->query('spf') == 'navigate') {
            // Override the layout. We are not using the global merge function here because
            // we want to override a previous value.
            $request->data['layout'] = 'spf';

            // Get the query paramters matched from the routes regex
            $query = $this->getRouteQuery($request);

            // Get the route parameters
            $parameters = $this->getRouteParameters($request, $method, $query);

            // Get the reflection controller
            $reflection = $this->getReflectionMethod($request->controller, $method);

            // Get the controller's view so have all the variables set by the controller
            $view = $reflection->invokeArgs(app($request->controller), $parameters);

            // Return the SPF JSON information
            return response()->json([
                'title' => view('partials.head-title', $view->getData())->render(),
                'body' => [
                    'menu-top-section' => view('partials.menu-top', $view->getData())->render(),
                    'content' => $view->render(),
                    'footer-contact' => view('partials.footer-contact', $view->getData())->render(),
                ],
                'foot' => view('partials.ga-pageview', $view->getData())->render(),
            ]);
        }

        return $next($request);
    }

    /**
     * Get the routes method parameters.
     *
     * @param \Illuminate\Http\Request $request $request
     * @param string $method
     * @param $query
     * @return array
     */
    public function getRouteParameters($request, $method, $query)
    {
        // Reflect on the controllers method
        $reflection = $this->getReflectionMethod($request->controller, $method);

        // Get the routes dependencies
        $dependencies = $reflection->getParameters();

        // Build an array of parameters which can be passed to the reflection method
        foreach ($dependencies as $key => $value) {
            if ($value->getName() == 'request') {
                $parameters[$value->getName()] = $request;
            } elseif (isset($query[$value->getName()])) {
                $parameters[$value->getName()] = $query[$value->getName()];
            }
        }

        return $parameters;
    }

    /**
     * Get the reflection object of the controllers method.
     *
     * @param string $controller
     * @param string $method
     * @return \ReflectionMethod
     */
    public function getReflectionMethod($controller, $method)
    {
        return new \ReflectionMethod($controller, $method);
    }

    /**
     * Get the query paramters matched from the routes regex.
     *
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function getRouteQuery($request)
    {
        return is_array($request->route()->parameters) ? $request->route()->parameters : [];
    }
}
