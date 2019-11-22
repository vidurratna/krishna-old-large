<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

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
            Route::apiResource('tags','Api\TagController');
            Route::apiResource('posts', 'Api\PostController');
            Route::apiResource('modules', 'Api\ContentModuleController');
            // Route::apiResource('events', 'EventController');

        });


        Route::group([
            'prefix' => '/user'
            ],function() {
                Route::post('/register', 'Api\AuthController@register');
                Route::post('/login', 'Api\AuthController@login');
                Route::post('/{user}/asign/{role}', 'Api\RoleController@asignRole');
        });
        

        Route::group([
            'prefix' => '/admin'
            ],function() {
                Route::apiResource('roles','Api\RoleController');
                Route::apiResource('permissions','Api\PermissionController');
                Route::apiResource('chapters','Api\ChapterController');
        });

        Route::group([
            'prefix' => '/permission'
            ],function() {
                Route::post('/{permission}/asign/{role}', 'Api\PermissionController@asignRole');
        });

        Route::group([
            'prefix' => '/tag'
            ],function() {
                Route::post('/{tag}/asign', 'Api\TagController@asign');
        });

        Route::get('/test', function(){
            $x = Cache::get('user.1.permissions');
            $x = collect($x);
            $y = Cache::get('permissions');

            return response(['user' => $x, 'whole' => collect($y)]);
        });
        
        
});