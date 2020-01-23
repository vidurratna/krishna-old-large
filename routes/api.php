<?php

use App\User;
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
            Route::apiResource('addresses', 'Api\AddressController');
            Route::apiResource('chapters','Api\ChapterController');
            // Route::apiResource('events', 'EventController');

            Route::group([
                'prefix' => '/info'
                ],function() {
                    Route::get('/all','Api\ChapterController@index');
                    Route::get('/{chapter}','Api\ChapterController@show');
                    Route::get('/','Api\ChapterController@me');
            });

            Route::post('/join', 'Api\ChapterController@join');
            Route::post('/leave', 'Api\ChapterController@leave');

            Route::group([
                'prefix' => '/user'
                ],function() {
                    Route::post('/register', 'Api\AuthController@register');
                    Route::post('/login', 'Api\AuthController@login');
                    Route::get('/account', 'Api\AuthController@show');
                    Route::patch('/account', 'Api\AuthController@update');
                    Route::post('/{user}/assign/{role}', 'Api\RoleController@assignRole');
            });

            Route::group([
                'prefix' => '/tag'
                ],function() {
                    Route::post('/{tag}/assign', 'Api\TagController@assign');
            });

            Route::group([
                'prefix' => '/address'
                ],function() {
                    Route::post('/{address}/assign', 'Api\AddressController@assign');
            });
            Route::get('/admin/users', 'Api\AuthController@index');
            Route::get('/admin/users/{user}', 'Api\AuthController@check');
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
                Route::post('/{permission}/assign/{role}', 'Api\PermissionController@asignRole');
        });

        

        Route::get('/check/cache', function(){
            $x = Cache::get('user.'. User::first()->id .'.permissions');
            $x = collect($x);
            $y = Cache::get('permissions');

            return response(['user' => $x, 'whole' => collect($y)]);
        });
        
        
});