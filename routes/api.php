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

Route::group(['prefix' => 'users'], function () {
    Route::get('/', 'API\UserController@getList');
    Route::post('create', 'API\UserController@postCreate');
    Route::post('update/{user}', 'API\UserController@postUpdate');
    Route::post('delete/{user}', 'API\UserController@postDelete');
});
Route::group(['prefix' => 'roles'], function () {
    Route::get('/', 'API\RoleController@getList');
    Route::post('create', 'API\RoleController@postCreate');
    Route::post('update/{role}', 'API\RoleController@postUpdate');
    Route::post('delete/{role}', 'API\RoleController@postDelete');
});


Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('logout', 'API\Auth\AuthController@getLogout');
});