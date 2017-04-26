<?php

// News listing route
$app->get('{path:.*/?news}/category/{slug:.+}', ['middleware' => ['data', 'formy', 'spf'], 'uses' => 'NewsController@index']);
$app->get('{path:.*/?news}/{slug:.+}-{id:\d+}', ['middleware' => ['data', 'formy', 'spf:show'], 'uses' => 'NewsController@show']);
$app->get('{path:.*/?news}/', ['middleware' => ['data', 'formy', 'spf'], 'uses' => 'NewsController@index']);

// Individual profile route
$app->get('{path:.*/?profile}/{accessid:.+}', ['middleware' => ['data', 'formy', 'spf:show'], 'uses' => 'ProfileController@show']);

// The wild card route is a catch all route that tries to resolve the requests path to a json file
$app->addRoute(['GET', 'POST'], '{path:.*}', ['middleware' => ['data', 'formy', 'spf'], function ($path, Illuminate\Http\Request $request) use ($app) {
    return app($request->controller)->index($request);
}]);
