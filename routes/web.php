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


Route::get('/user', function () {
    return view('sistema.user.users');
})->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');



//User
Route::post('/user', 'UserController@store');
Route::post('/user/{id}', 'UserController@show');
Route::post('/user/delete/{id}', 'UserController@destroy');
Route::post('/avatar', 'UserController@upload');
Route::get('/avatar/{filname}', 'UserController@getImage');