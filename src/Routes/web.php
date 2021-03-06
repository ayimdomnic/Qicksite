<?php

    Route::group(['middleware' => 'web'], function () {

        /*
        |--------------------------------------------------------------------------
        | Public Routes
        |--------------------------------------------------------------------------
        */

        Route::get('public-preview/{encFileName}', 'AssetController@asPreview');
        Route::get('public-asset/{encFileName}', 'AssetController@asPublic');
        Route::get('public-download/{encFileName}/{encRealFileName}', 'AssetController@asDownload');

        /*
        |--------------------------------------------------------------------------
        | APIs
        |--------------------------------------------------------------------------
        */

        Route::group(['prefix' => 'quicksite/api'], function () {
            Route::get('images/list', 'ImagesController@apiList');
            Route::post('images/store', 'ImagesController@apiStore');
            Route::get('files/list', 'FilesController@apiList');

            Route::group(['middleware' => ['quicksite-api']], function () {
                Route::get('blog', 'ApiController@all');
                Route::get('blog/{id}', 'ApiController@find');

                Route::get('events', 'ApiController@all');
                Route::get('events/{id}', 'ApiController@find');

                Route::get('faqs', 'ApiController@all');
                Route::get('faqs/{id}', 'ApiController@find');

                Route::get('files', 'ApiController@all');
                Route::get('files/{id}', 'ApiController@find');

                Route::get('images', 'ApiController@all');
                Route::get('images/{id}', 'ApiController@find');

                Route::get('pages', 'ApiController@all');
                Route::get('pages/{id}', 'ApiController@find');

                Route::get('widgets', 'ApiController@all');
                Route::get('widgets/{id}', 'ApiController@find');
            });
        });

        /*
        |--------------------------------------------------------------------------
        | quicksite
        |--------------------------------------------------------------------------
        */

        Route::group(['prefix' => 'quicksite'], function () {
            Route::get('asset/{path}/{contentType}', 'AssetController@asset');

            Route::group(['middleware' => ['auth', 'quicksite']], function () {
                Route::get('dashboard', 'DashboardController@main');
                Route::get('help', 'HelpController@main');

                /*
                |--------------------------------------------------------------------------
                | Common Features
                |--------------------------------------------------------------------------
                */

                Route::get('preview/{entity}/{entityId}', 'quicksiteFeatureController@preview');
                Route::get('rollback/{entity}/{entityId}', 'quicksiteFeatureController@rollback');

                /*
                |--------------------------------------------------------------------------
                | Menus
                |--------------------------------------------------------------------------
                */

                Route::resource('menus', 'MenuController', ['as' => 'quicksite']);
                Route::post('menus/search', 'MenuController@search');

                /*
                |--------------------------------------------------------------------------
                | Links
                |--------------------------------------------------------------------------
                */

                Route::resource('links', 'LinksController', ['except' => ['index', 'show'], 'as' => 'quicksite']);
                Route::post('links/search', 'LinksController@search');

                /*
                |--------------------------------------------------------------------------
                | Images
                |--------------------------------------------------------------------------
                */

                Route::resource('images', 'ImagesController', ['as' => 'quicksite', 'except' => ['show']]);
                Route::post('images/search', 'ImagesController@search');
                Route::post('images/upload', 'ImagesController@upload');

                /*
                |--------------------------------------------------------------------------
                | Blog
                |--------------------------------------------------------------------------
                */

                Route::resource('blog', 'BlogController', ['as' => 'quicksite', 'except' => ['show']]);
                Route::post('blog/search', 'BlogController@search');

                /*
                |--------------------------------------------------------------------------
                | Pages
                |--------------------------------------------------------------------------
                */

                Route::resource('pages', 'PagesController', ['as' => 'quicksite', 'except' => ['show']]);
                Route::post('pages/search', 'PagesController@search');

                /*
                |--------------------------------------------------------------------------
                | Widgets
                |--------------------------------------------------------------------------
                */

                Route::resource('widgets', 'WidgetsController', ['as' => 'quicksite', 'except' => ['show']]);
                Route::post('widgets/search', 'WidgetsController@search');

                /*
                |--------------------------------------------------------------------------
                | FAQs
                |--------------------------------------------------------------------------
                */

                Route::resource('faqs', 'FAQController', ['as' => 'quicksite', 'except' => ['show']]);
                Route::post('faqs/search', 'FAQController@search');

                /*
                |--------------------------------------------------------------------------
                | Events
                |--------------------------------------------------------------------------
                */

                Route::resource('events', 'EventController', ['as' => 'quicksite', 'except' => ['show']]);
                Route::post('events/search', 'EventController@search');

                /*
                |--------------------------------------------------------------------------
                | Files
                |--------------------------------------------------------------------------
                */

                Route::get('files/remove/{id}', 'FilesController@remove');
                Route::post('files/upload', 'FilesController@upload');
                Route::post('files/search', 'FilesController@search');

                Route::resource('files', 'FilesController', ['as' => 'quicksite', 'except' => ['show']]);
            });
        });
    });
