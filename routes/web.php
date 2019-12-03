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
Route::get('{any?}profile/{accessid?}', 'ProfileController@show')
    ->where(['any' => '.*', 'accessid' => '[a-zA-Z]{2}\d{4}']);

// News listing by topic
Route::get('{any?}'.config('base.news_listing_route').'/'.config('base.news_topic_route').'/{slug}', config('base.news_controller').'@index')
    ->where(['any' => '.*', 'slug' => '.+']);

// News view
Route::get('{any?}'.config('base.news_view_route').'/{slug}-{id}', config('base.news_controller').'@show')
    ->where(['any' => '.*', 'slug' => '.+', 'id' => '\d+']);

// The wild card route is a catch all route that tries to resolve the requests path to a json file
Route::match(['get', 'post'], '{path}', 'WildCardController@index')
    ->where('path', '.*');
