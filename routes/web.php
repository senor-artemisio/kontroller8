<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

$routes = [
    '/',
    '/dashboard',
    '/items',
    '/items/new',
    '/calendar'
];

foreach ($routes as $route) {
    Route::get($route, 'AppController@index');
}

Route::get('/item/{id}', 'AppController@index')->where('id', '[A-Za-z0-9]+');
Route::get('/items/{page}', 'AppController@index')->where('page', '[0-9]+');

Route::get('/auth', function (){
    return view('auth');
});
