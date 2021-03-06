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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


Route::get('users', 'UserController@users');
Route::get('cat-ingredientes', 'ingredienteController@categorias');
Route::get('ingredientes', 'ingredienteController@ingredientes');
Route::get('cat-productos', 'productoController@categorias');
Route::get('productos', 'productoController@productos');
Route::get('ordenes', 'OrdenesController@ordenesListas');
Route::post('permisos', 'PermisoController@permisos');
Route::get('reporte/ordenes/{desde?}/{hasta}', 'OrdenesController@consultaOrdenes');
Route::get('reporte/facturas/{desde?}/{hasta}', 'OrdenesController@consultaFacturas');
Route::get('reporte/facturas/dia', 'OrdenesController@consultaUltimasFacturas');
Route::get('reporte/inventario', 'OrdenesController@consultaInventario');

