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
Route::get('{path}/{accessid}', 'ProfileController@show')
    ->where(['path' => '(?:.*\/|)profile', 'accessid' => '.+'])
    ->middleware('data', 'formy');

// News by category
Route::get('{path}/category/{slug}', 'NewsController@index')
    ->where(['path' => '(?:.*\/|)news', 'slug' => '.+'])
    ->middleware('data', 'formy');

// News view
Route::get('{path}/{slug}-{id}', 'NewsController@show')
    ->where(['path' => '(?:.*\/|)news', 'slug' => '.+', 'id' => '\d+'])
    ->middleware('data', 'formy');

// News listing
Route::get('{path}', 'NewsController@index')
    ->name('news')
    ->where('path', '(?:.*\/|)news')
    ->middleware('data', 'formy');

// The wild card route is a catch all route that tries to resolve the requests path to a json file
Route::match(['get', 'post'], '{any}', function (Illuminate\Http\Request $request) {
        return app($request->controller)->index($request);
    })
    ->where('any', '.*')
    ->middleware('data', 'formy');
