<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PromoPageController;
use App\Http\Controllers\WildCardController;

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

// Individual promo view route
Route::get('{any?}view/{title}-{id}', [PromoPageController::class, 'show'])
    ->where(['any' => '.*', 'title' => '.+', 'id' => '\d+']);

// Profile view
Route::get('{any?}profile/{accessid?}', [ProfileController::class, 'show'])
    ->where(['any' => '.*', 'accessid' => '[a-zA-Z]{2}\d{4}']);

// News listing by topic
Route::get('{any?}'.config('base.news_listing_route').'/'.config('base.news_topic_route').'/{slug}', [config('base.news_controller'), 'index'])
    ->where(['any' => '.*', 'slug' => '.+']);

// News view
Route::get('{any?}'.config('base.news_view_route').'/{slug}-{id}', [config('base.news_controller'), 'show'])
    ->where(['any' => '.*', 'slug' => '.+', 'id' => '\d+']);

// The wild card route is a catch all route that tries to resolve the requests path to a json file
Route::match(['get', 'post'], '{path}', [WildCardController::class, 'index'])
    ->where('path', '.*');
