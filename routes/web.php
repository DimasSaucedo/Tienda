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
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);

Route::get('/llantasP', [App\Http\Controllers\PotrerosController::class, 'index']);
Route::post('/agregarLlanta', [App\Http\Controllers\PotrerosController::class, 'agregarLlanta']);
Route::post('/eliminar_llantap', [App\Http\Controllers\PotrerosController::class, 'eliminarLlanta']);
Route::put('/actualizar_llanta_p', [App\Http\Controllers\PotrerosController::class, 'actualizaLlanta']);
Route::get('/bateriasP', [App\Http\Controllers\PotrerosController::class, 'baterias']);
Route::post('/agregarBateria', [App\Http\Controllers\PotrerosController::class, 'agregarBateria']);
Route::post('/eliminar_bateriap', [App\Http\Controllers\PotrerosController::class, 'eliminarBateria']);
Route::put('/actualizar_bateria_p', [App\Http\Controllers\PotrerosController::class, 'actualizaBateria']);

Route::get('/llantasG', [App\Http\Controllers\GuadalupanoController::class, 'index']);
Route::post('/agregarLlantaG', [App\Http\Controllers\GuadalupanoController::class, 'agregarLlanta']);
Route::post('/eliminar_llantaG', [App\Http\Controllers\GuadalupanoController::class, 'eliminarLlanta']);
Route::put('/actualizar_llanta_G', [App\Http\Controllers\GuadalupanoController::class, 'actualizaLlanta']);
Route::get('/bateriasG', [App\Http\Controllers\GuadalupanoController::class, 'baterias']);
Route::post('/agregarBateriaG', [App\Http\Controllers\GuadalupanoController::class, 'agregarBateria']);
Route::post('/eliminar_bateriag', [App\Http\Controllers\GuadalupanoController::class, 'eliminarBateria']);
Route::put('/actualizar_bateria_g', [App\Http\Controllers\GuadalupanoController::class, 'actualizaBateria']);
