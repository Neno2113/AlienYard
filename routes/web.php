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
//vistas
Route::get('/', function () {
    return view('/home');
})->middleware('auth');


Route::get('/user', function () {
    return view('sistema.user.users');
})->middleware('auth');


Route::get('/categoria-ingredientes', function () {
    return view('sistema.ingredientes.categoria');
})->middleware('auth');


Route::get('/ingredientes', function () {
    return view('sistema.ingredientes.ingrediente');
})->middleware('auth');



Route::get('/categoria-producto', function () {
    return view('sistema.producto.categoria');
})->middleware('auth');


Route::get('/productos', function () {
    return view('sistema.producto.producto');
})->middleware('auth');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


//rutas sistema
//User
Route::post('/user', 'UserController@store');
Route::post('/user/{id}', 'UserController@show');
Route::post('/user/delete/{id}', 'UserController@destroy');
Route::post('/avatar', 'UserController@upload');
Route::get('/avatar/{filname}', 'UserController@getImage');

//ingredientes
Route::post('/categoria/ingrediente', 'ingredienteController@storeCategoria');
Route::post('/categoria/delete/{id}', 'ingredienteController@destroy');
Route::post('/categoria/{id}', 'ingredienteController@show');
Route::post('/ingrediente', 'ingredienteController@store');
Route::get('/categoria/select', 'ingredienteController@categoriasSelect');
Route::post('/ingrediente/delete/{id}', 'ingredienteController@destroyIngrediente');
Route::get('/ingrediente/{id}', 'ingredienteController@showIngrediente');


//producto
Route::post('/categoria-producto', 'productoController@storeCategoria');
Route::post('/categoria-producto/delete/{id}', 'productoController@destroy');
Route::post('/categoria-producto/{id}', 'productoController@show');
Route::get('/categoria/producto', 'productoController@categoriasSelect');
Route::post('/producto-imagen', 'productoController@upload');
Route::get('/producto/{filname}', 'productoController@getImage');
Route::post('/ingrediente-select', 'productoController@ingredienteSelect');
Route::get('catIngrediente-select', 'productoController@ingredienteCategoriaSelect');
Route::post('/producto', 'productoController@store');
Route::post('/receta', 'productoController@storeReceta');
Route::post('/ingrediente/receta/{id}', 'productoController@delIngrediente');
Route::post('/producto/delete/{id}', 'productoController@destroyProducto');
Route::get('/producto/mostrar/{id}', 'productoController@showProducto');