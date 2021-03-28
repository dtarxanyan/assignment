<?php

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

Route::group(['prefix' => 'v1'], function () {
    Route::get('auth/access_token', 'AuthController@loginWithFacebook')->name('auth.loginWithFacebook');;

    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('/users/{user}', 'UserController@show')->name('users.show');
        Route::post('/files', 'FileController@store')->name('files.store');
        Route::get('/tasks', 'TaskController@index')->name('tasks.index');
    });
});



