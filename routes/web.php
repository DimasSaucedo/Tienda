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

Route::get('/llantasP', [App\Http\Controllers\PotrerosController::class, 'index'])->middleware('auth');
Route::post('/agregarLlanta', [App\Http\Controllers\PotrerosController::class, 'agregarLlanta'])->middleware('auth');
Route::post('/eliminar_llantap', [App\Http\Controllers\PotrerosController::class, 'eliminarLlanta'])->middleware('auth');
Route::put('/actualizar_llanta_p', [App\Http\Controllers\PotrerosController::class, 'actualizaLlanta'])->middleware('auth');
Route::get('/bateriasP', [App\Http\Controllers\PotrerosController::class, 'baterias'])->middleware('auth');
Route::post('/agregarBateria', [App\Http\Controllers\PotrerosController::class, 'agregarBateria'])->middleware('auth');
Route::post('/eliminar_bateriap', [App\Http\Controllers\PotrerosController::class, 'eliminarBateria'])->middleware('auth');
Route::put('/actualizar_bateria_p', [App\Http\Controllers\PotrerosController::class, 'actualizaBateria'])->middleware('auth');

Route::get('/llantasG', [App\Http\Controllers\GuadalupanoController::class, 'index'])->middleware('auth');
Route::post('/agregarLlantaG', [App\Http\Controllers\GuadalupanoController::class, 'agregarLlanta'])->middleware('auth');
Route::post('/eliminar_llantaG', [App\Http\Controllers\GuadalupanoController::class, 'eliminarLlanta'])->middleware('auth');
Route::put('/actualizar_llanta_G', [App\Http\Controllers\GuadalupanoController::class, 'actualizaLlanta'])->middleware('auth');
Route::get('/bateriasG', [App\Http\Controllers\GuadalupanoController::class, 'baterias'])->middleware('auth');
Route::post('/agregarBateriaG', [App\Http\Controllers\GuadalupanoController::class, 'agregarBateria'])->middleware('auth');
Route::post('/eliminar_bateriag', [App\Http\Controllers\GuadalupanoController::class, 'eliminarBateria'])->middleware('auth');
Route::put('/actualizar_bateria_g', [App\Http\Controllers\GuadalupanoController::class, 'actualizaBateria'])->middleware('auth');

Route::get('/checador', [App\Http\Controllers\ChecadorController::class, 'index'])->middleware('auth');

Route::get('/administrador', [App\Http\Controllers\AdministradorController::class, 'index'])->middleware('auth');
Route::get('/ventas', [App\Http\Controllers\AdministradorController::class, 'index_ventas'])->middleware('auth');
Route::post('/vender_producto', [App\Http\Controllers\AdministradorController::class, 'vender_producto'])->middleware('auth');
Route::post('/confirmar_venta', [App\Http\Controllers\AdministradorController::class, 'confirmar_venta'])->middleware('auth');
Route::post('/eliminar_solicitud_venta', [App\Http\Controllers\AdministradorController::class, 'eliminar_solicitud_venta'])->middleware('auth');
Route::post('/agregar_venta', [App\Http\Controllers\AdministradorController::class, 'agregar_venta'])->middleware('auth');
Route::post('/eliminar_venta', [App\Http\Controllers\AdministradorController::class, 'eliminar_venta'])->middleware('auth');
Route::post('/editar_venta', [App\Http\Controllers\AdministradorController::class, 'editar_venta'])->middleware('auth');
Route::post('/editar_venta_confirmar', [App\Http\Controllers\AdministradorController::class, 'editar_venta_confirmar'])->middleware('auth');