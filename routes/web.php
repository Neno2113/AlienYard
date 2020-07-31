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
})->middleware('auth', 'Admin:Usuarios');

Route::get('/user-only', function () {
    return view('sistema.user.userOnly');
})->middleware('auth', 'Admin:Usuarios');


Route::get('/categoria-ingredientes', function () {
    return view('sistema.ingredientes.categoria');
})->middleware('auth', 'Admin:Categoria ingredientes');


Route::get('/ingredientes', function () {
    return view('sistema.ingredientes.ingrediente');
})->middleware('auth', 'Admin:Ingredientes');



Route::get('/categoria-producto', function () {
    return view('sistema.producto.categoria');
})->middleware('auth', 'Admin:Categoria producto');


Route::get('/productos', function () {
    return view('sistema.producto.producto');
})->middleware('auth', 'Admin:Producto');

Route::get('/menu', function () {
    return view('sistema.ordenes.menu');
})->middleware('auth', 'Admin:Menu');

Route::get('/ordenes', function () {
    return view('sistema.ordenes.ordenes');
})->middleware('auth', 'Admin:Ordenes');

Route::get('/cobro', function () {
    return view('sistema.ordenes.cobro');
})->middleware('auth', 'Admin:Pago');

Route::get('/permisos', function () {
    return view('sistema.user.permiso');
})->middleware('auth');

Route::get('/consulta-orden', function () {
    return view('sistema.consultas.consulta');
})->middleware('auth');


Route::get('/consulta-facturas', function () {
    return view('sistema.consultas.facturas');
})->middleware('auth');

Route::get('/consulta-inventario', function () {
    return view('sistema.consultas.inventario');
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
Route::get('/producto/img/{filname}', 'productoController@getImage');
Route::post('/ingrediente-select', 'productoController@ingredienteSelect');
Route::get('catIngrediente-select', 'productoController@ingredienteCategoriaSelect');
Route::post('/producto', 'productoController@store');
Route::post('/receta', 'productoController@storeReceta');
Route::post('/ingrediente/receta/{id}', 'productoController@delIngrediente');
Route::post('/producto/delete/{id}', 'productoController@destroyProducto');
Route::get('/producto/mostrar/{id}', 'productoController@showProducto');
Route::post('/producto/desactivar/{id}', 'productoController@desactivar');
Route::post('/producto/activar/{id}', 'productoController@activar');

//Menu
Route::get('/categoria-menu', 'productoController@categoriaMenu');
Route::get('/menu/categoria/{id}', 'productoController@menu');
Route::get('/menu/ver/{id}', 'productoController@verMenu');
Route::get('/metodo-pago', 'OrdenesController@metodoPagoSelect');
Route::get('/canal-orden', 'OrdenesController@canal');
Route::post('/orden', 'OrdenesController@store');
Route::post('/agregar-pedido/{id}', 'OrdenesController@storeDetalle');
Route::post('/detalle/delete/{id}', 'OrdenesController@destroyDetalle');
Route::post('/update-costo/{id}', 'OrdenesController@updateCosto');
Route::get('/producto-receta/{id}', 'OrdenesController@recetaProducto');
Route::post('/comentario', 'OrdenesController@comentario');
Route::post('/entrega/plato', 'OrdenesController@entrega');
Route::post('/delete-comment', 'OrdenesController@destroyComment');
Route::post('/comentario-manual', 'OrdenesController@comentarioManual');

//ordenes
Route::get('/pedidos', 'OrdenesController@ordenes');
Route::get('/secuencia/orden', 'OrdenesController@getDigits');
Route::get('/orden/{id}', 'OrdenesController@orden');
Route::get('/orden/comentarios/{id}', 'OrdenesController@platoComentario');
Route::post('/orden/delete/{id}', 'OrdenesController@destroy');
Route::post('/orden/preparar/{id}', 'OrdenesController@updateState');
Route::post('/orden/lista', 'OrdenesController@updateReady');
Route::get('/orden/cobro/{id}', 'OrdenesController@show');
Route::post('/facturar/total', 'OrdenesController@storeFacturaCompleta');
Route::post('/facturar/termino', 'OrdenesController@ordenFacturada');
Route::post('/facturar/manual', 'OrdenesController@storeFacturaManual');
Route::post('/facturar/agregar/{id}', 'OrdenesController@agregarDetalle');
Route::post('/facturar/seleccionar', 'OrdenesController@seleccionar');
Route::post('/facturar/terminar', 'OrdenesController@terminarFacturaManual');
Route::get('/imprimir/factura/{id}', 'OrdenesController@imprimir');
Route::post('/monto/aplicar', 'OrdenesController@aplicar');
Route::get('/factura/sec', 'OrdenesController@getNoFactura');

//Permiso
Route::get('permiso/{id}', 'PermisoController@show');
Route::get('usuarios', 'PermisoController@usuarios');
Route::post('permiso', 'PermisoController@store');
Route::post('permiso/delete/{id}', 'PermisoController@destroy');


//Dashboard
Route::get('venta12meses', 'HomeController@ventas12meses');
Route::get('venta10dias', 'HomeController@ventas10dias');
Route::get('ventasDelDia', 'HomeController@ventasDelDia');
Route::get('ordenes/nuevas', 'HomeController@ordenesNuevas');
Route::get('ordenes/proceso', 'HomeController@ordenesProceso');
Route::get('ordenes/listas', 'HomeController@ordenesLista');
Route::get('inventario', 'HomeController@inventario');

//consultas
// Route::get('reporte/ordenes/{desde}/{hasta}', 'OrdenesController@consultaOrdenes');
