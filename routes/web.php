<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {

    // $password = '123';
    // $hashedPassword = Hash::make($password);

    // dd($hashedPassword);

    return redirect('login');
});

Auth::routes();
//Route::get('/home', [App\Http\Controllers\ReporteController::class, 'home']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware('auth');

//Potreros
Route::get('/llantasP', [App\Http\Controllers\PotrerosController::class, 'index'])->middleware('auth');
Route::post('/agregarLlanta', [App\Http\Controllers\PotrerosController::class, 'agregarLlanta'])->middleware('auth');
Route::post('/eliminar_llantap', [App\Http\Controllers\PotrerosController::class, 'eliminarLlanta'])->middleware('auth');
Route::put('/actualizar_llanta_p', [App\Http\Controllers\PotrerosController::class, 'actualizaLlanta'])->middleware('auth');
Route::get('/bateriasP', [App\Http\Controllers\PotrerosController::class, 'baterias'])->middleware('auth');
Route::post('/agregarBateria', [App\Http\Controllers\PotrerosController::class, 'agregarBateria'])->middleware('auth');
Route::post('/eliminar_bateriap', [App\Http\Controllers\PotrerosController::class, 'eliminarBateria'])->middleware('auth');
Route::put('/actualizar_bateria_p', [App\Http\Controllers\PotrerosController::class, 'actualizaBateria'])->middleware('auth');

//Guadalupano
Route::get('/llantasG', [App\Http\Controllers\GuadalupanoController::class, 'index'])->middleware('auth');
Route::post('/agregarLlantaG', [App\Http\Controllers\GuadalupanoController::class, 'agregarLlanta'])->middleware('auth');
Route::post('/eliminar_llantaG', [App\Http\Controllers\GuadalupanoController::class, 'eliminarLlanta'])->middleware('auth');
Route::put('/actualizar_llanta_G', [App\Http\Controllers\GuadalupanoController::class, 'actualizaLlanta'])->middleware('auth');
Route::get('/bateriasG', [App\Http\Controllers\GuadalupanoController::class, 'baterias'])->middleware('auth');
Route::post('/agregarBateriaG', [App\Http\Controllers\GuadalupanoController::class, 'agregarBateria'])->middleware('auth');
Route::post('/eliminar_bateriag', [App\Http\Controllers\GuadalupanoController::class, 'eliminarBateria'])->middleware('auth');
Route::put('/actualizar_bateria_g', [App\Http\Controllers\GuadalupanoController::class, 'actualizaBateria'])->middleware('auth');

//Checador
Route::get('/checador', [App\Http\Controllers\ChecadorController::class, 'index'])->middleware('auth');

//Administrador
Route::get('/administrador', [App\Http\Controllers\AdministradorController::class, 'index'])->middleware('auth');

//Ventas
Route::get('/ventas', [App\Http\Controllers\AdministradorController::class, 'index_ventas'])->middleware('auth');
Route::post('/vender_producto', [App\Http\Controllers\AdministradorController::class, 'vender_producto'])->middleware('auth');
Route::post('/confirmar_venta', [App\Http\Controllers\AdministradorController::class, 'confirmar_venta'])->middleware('auth');
Route::post('/eliminar_solicitud_venta', [App\Http\Controllers\AdministradorController::class, 'eliminar_solicitud_venta'])->middleware('auth');
Route::post('/agregar_venta', [App\Http\Controllers\AdministradorController::class, 'agregar_venta'])->middleware('auth');
Route::post('/eliminar_venta', [App\Http\Controllers\AdministradorController::class, 'eliminar_venta'])->middleware('auth');
Route::post('/editar_venta', [App\Http\Controllers\AdministradorController::class, 'editar_venta'])->middleware('auth');
Route::post('/editar_venta_confirmar', [App\Http\Controllers\AdministradorController::class, 'editar_venta_confirmar'])->middleware('auth');
Route::post('/buscar_ventas', [App\Http\Controllers\AdministradorController::class, 'buscar_ventas'])->middleware('auth');

//Gastos
Route::get('/gastos', [App\Http\Controllers\GastosController::class, 'index'])->middleware('auth');
Route::post('/guardar_gasto', [App\Http\Controllers\GastosController::class, 'guardar_gasto'])->middleware('auth');
Route::post('/eliminar_gasto', [App\Http\Controllers\GastosController::class, 'eliminar_gasto'])->middleware('auth');


//Usuarios
Route::get('/usuarios', [App\Http\Controllers\UsuariosController::class, 'index'])->middleware('auth');
Route::post('/habilitar_usuario', [App\Http\Controllers\UsuariosController::class, 'habilitar_usuario'])->middleware('auth');
Route::post('/deshabilitar_usuario', [App\Http\Controllers\UsuariosController::class, 'deshabilitar_usuario'])->middleware('auth');
Route::post('/editar_usuario', [App\Http\Controllers\UsuariosController::class, 'editar_usuario'])->middleware('auth');

//Apartados
Route::get('/apartados', [App\Http\Controllers\ApartadosController::class, 'index'])->middleware('auth');
Route::get('/agregar_apartado', [App\Http\Controllers\ApartadosController::class, 'crear_nota'])->middleware('auth');
Route::post('/agregar_apartado', [App\Http\Controllers\ApartadosController::class, 'guardar_nota'])->middleware('auth');
Route::get('/agregar_producto', [App\Http\Controllers\ApartadosController::class, 'crear_producto'])->middleware('auth');
Route::post('/guardar_producto', [App\Http\Controllers\ApartadosController::class, 'guardar_producto'])->middleware('auth');
Route::get('/agregar_abono', [App\Http\Controllers\ApartadosController::class, 'crear_abono'])->middleware('auth');
Route::post('/guardar_abono', [App\Http\Controllers\ApartadosController::class, 'guardar_abono'])->middleware('auth');
Route::post('/editar_nota', [App\Http\Controllers\ApartadosController::class, 'editar_nota'])->middleware('auth');
Route::post('/actualizar_nota', [App\Http\Controllers\ApartadosController::class, 'actualizar_nota'])->middleware('auth');
Route::post('/saldar_nota', [App\Http\Controllers\ApartadosController::class, 'saldar_nota'])->middleware('auth');