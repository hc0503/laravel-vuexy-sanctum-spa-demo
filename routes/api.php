<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('user', function (Request $request) {
        return response()->json([
            'userData' => $request->user()
        ]);
    });

    Route::get('permissions', 'API\PermissionController@getList');

    Route::group(['prefix' => 'profile'], function () {
        Route::get('/', 'API\ProfileController@getProfile');
        Route::post('/update', 'API\ProfileController@postUpdate');
    });
    
    Route::group(['prefix' => 'roles'], function () {
        Route::get('/', 'API\RoleController@getList');
        Route::post('create', 'API\RoleController@postCreate');
        Route::get('detail/{role}', 'API\RoleController@getDetail');
        Route::post('update/{role}', 'API\RoleController@postUpdate');
        Route::post('delete/{role}', 'API\RoleController@postDelete');
    });

    Route::group(['prefix' => 'users'], function () {
        Route::get('/', 'API\UserController@getList')->middleware('permission:viewuser');
        Route::post('create', 'API\UserController@postCreate')->middleware('permission:createuser');
        Route::get('detail/{user}', 'API\UserController@getDetail')->middleware('permission:viewuser');
        Route::post('update/{user}', 'API\UserController@postUpdate')->middleware('permission:edituser');
        Route::post('delete/{user}', 'API\UserController@postDelete')->middleware('permission:deleteuser');
        Route::post('status/{user}', 'API\UserController@postStatus')->middleware('permission:edituser');
    });
});