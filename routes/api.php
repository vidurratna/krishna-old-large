<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::group([
    'prefix' => '/v1'
    ],function() {

        Route::group([
            'prefex'        => '/{chapter}',
            'middleware'    => \App\Http\Middleware\IdentifyChapter::class,
            'as'            => 'chapter:',
        ], function () {

            Route::apiResource('posts', 'Api\PostController');
            // Route::apiResource('events', 'EventController');

        });


        Route::group([
            'prefix' => '/user'
            ],function() {
                Route::post('/register', 'Api\AuthController@register');
                Route::post('/login', 'Api\AuthController@login');
        });
});