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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/user_panel', 'HomeController@index')->name('User Panel')->middleware('cors');
Route::get('/user', 'UserController@index');
Route::get('/online_users', 'UserController@getOnlineUsers');
Route::get('/user_geopoint/{id}', 'UserGeopointController@show');
Route::post('/user_geopoint/{id}', 'UserGeopointController@update');
