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
Route::post('/login', 'API\Auth\AuthController@login')->name('login');





Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('logout', 'API\Auth\AuthController@getLogout');
    Route::get('permissions', 'API\PermissionController@getList');

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
    });
});