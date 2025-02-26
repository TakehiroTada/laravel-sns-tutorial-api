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

Route::prefix('auth')->group(
    function () {
        Route::post('login', 'AuthController@login');
    }
);

Route::middleware(['auth:api'])->group(
    function () {
        Route::resource('users', 'UserController', ['except' => ['create', 'edit']]);
        Route::prefix('auth')->group(
            function () {
                Route::post('logout', 'AuthController@logout');
                Route::post('refresh', 'AuthController@refresh');
                Route::post('me', 'AuthController@me');
            }
        );
    }
);
