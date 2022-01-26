<?php

use Illuminate\Support\Facades\Route;
use Digitlimit\StoryblokAlgolia\Http\Controllers\SearchController;
use Digitlimit\StoryblokAlgolia\Http\Controllers\StoryblokController;

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

Route::prefix('storyblok')->name('storyblok-algolia.')->group(
    function () {

        if (config('storyblok-algolia.webhook_enabled', true)) {
            Route::post(
                config('storyblok-algolia.webhook_url', '/webhook'), 
                [StoryblokController::class, 'webhook']
            )
            ->name('webhook');
        }

        if (config('storyblok-algolia.search_enabled', true)) {
            Route::get(
                config('storyblok-algolia.search_url', '/search'), 
                [SearchController::class, 'search']
            )
            ->name('search');
        }

        // Route::get('/run-index', [StoryblokController::class, 'runIndex'])
        //     ->name('runIndex');
    }
);
