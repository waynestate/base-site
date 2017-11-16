<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Profile view
Route::get('{path}profile/{accessid}', 'ProfileController@show')
    ->where(['path' => '.*/?', 'accessid' => '.+'])
    ->middleware('data', 'formy', 'spf');

// News by category
Route::get('{path}news/category/{slug}', 'NewsController@index')
    ->where(['path' => '.*/?', 'slug' => '.+'])
    ->middleware('data', 'formy', 'spf');

// News view
Route::get('{path}news/{slug}-{id}', 'NewsController@show')
    ->where(['path' => '.*/?', 'slug' => '.+', 'id' => '\d+'])
    ->middleware('data', 'formy', 'spf');

// News listing
Route::get('{path}news', 'NewsController@index')
    ->where('path', '.*/?')
    ->middleware('data', 'formy', 'spf');

// The wild card route is a catch all route that tries to resolve the requests path to a json file
Route::match(['get', 'post'], '{path}', function (Illuminate\Http\Request $request) {
        return app($request->controller)->index($request);
    })
    ->where('path', '.*')
    ->middleware('data', 'formy', 'spf');
