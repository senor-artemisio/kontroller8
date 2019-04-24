<?php

use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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

Route::middleware(['json'])->group(function () {
    Route::middleware(['auth:api'])->group(function () {
        Route::resource('meals', 'MealController')
            ->only('index', 'show', 'store', 'destroy', 'update');

        Route::resource('days', 'DayController')
            ->only('index', 'store', 'destroy', 'update', 'show');

        Route::resource('days/{day}/portions', 'PortionController')
            ->only('index', 'store', 'destroy', 'update');

        Route::get('users/me', 'UserController@me');
    });
    Route::post('auth/sign-in', 'AuthController@signin');
    Route::post('auth/sign-up', 'AuthController@signup');

    Route::any('{any}', function () {
        throw new NotFoundHttpException('Not found');
    })->where('any', '.*');
});


