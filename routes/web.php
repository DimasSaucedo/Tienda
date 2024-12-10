<?php

use App\Http\Middleware\Autenticacion;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {

    // $password = '123';
    // $hashedPassword = Hash::make($password);

    // dd($hashedPassword);

    return redirect('rines');
});

Auth::routes();
//Route::get('/home', [App\Http\Controllers\ReporteController::class, 'home']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->middleware(Autenticacion::class);

//Potreros
Route::get('/llantasP', [App\Http\Controllers\PotrerosController::class, 'index'])->middleware(Autenticacion::class);
Route::post('/agregarLlanta', [App\Http\Controllers\PotrerosController::class, 'agregarLlanta'])->middleware(Autenticacion::class);
Route::post('/eliminar_llantap', [App\Http\Controllers\PotrerosController::class, 'eliminarLlanta'])->middleware(Autenticacion::class);
Route::post('/actualizar_llanta_p', [App\Http\Controllers\PotrerosController::class, 'actualizaLlanta'])->middleware(Autenticacion::class);
Route::get('/bateriasP', [App\Http\Controllers\PotrerosController::class, 'baterias'])->middleware(Autenticacion::class);
Route::post('/agregarBateria', [App\Http\Controllers\PotrerosController::class, 'agregarBateria'])->middleware(Autenticacion::class);
Route::post('/eliminar_bateriap', [App\Http\Controllers\PotrerosController::class, 'eliminarBateria'])->middleware(Autenticacion::class);
Route::post('/actualizar_bateria_p', [App\Http\Controllers\PotrerosController::class, 'actualizaBateria'])->middleware(Autenticacion::class);

//Guadalupano
Route::get('/llantasG', [App\Http\Controllers\GuadalupanoController::class, 'index'])->middleware(Autenticacion::class);
Route::post('/agregarLlantaG', [App\Http\Controllers\GuadalupanoController::class, 'agregarLlanta'])->middleware(Autenticacion::class);
Route::post('/eliminar_llantaG', [App\Http\Controllers\GuadalupanoController::class, 'eliminarLlanta'])->middleware(Autenticacion::class);
Route::post('/actualizar_llanta_G', [App\Http\Controllers\GuadalupanoController::class, 'actualizaLlanta'])->middleware(Autenticacion::class);
Route::get('/bateriasG', [App\Http\Controllers\GuadalupanoController::class, 'baterias'])->middleware(Autenticacion::class);
Route::post('/agregarBateriaG', [App\Http\Controllers\GuadalupanoController::class, 'agregarBateria'])->middleware(Autenticacion::class);
Route::post('/eliminar_bateriag', [App\Http\Controllers\GuadalupanoController::class, 'eliminarBateria'])->middleware(Autenticacion::class);
Route::post('/actualizar_bateria_g', [App\Http\Controllers\GuadalupanoController::class, 'actualizaBateria'])->middleware(Autenticacion::class);

//Checador
Route::get('/checador', [App\Http\Controllers\ChecadorController::class, 'index'])->middleware(Autenticacion::class);

//Administrador
Route::get('/administrador', [App\Http\Controllers\AdministradorController::class, 'index'])->middleware(Autenticacion::class);

//Ventas
Route::get('/ventas', [App\Http\Controllers\AdministradorController::class, 'index_ventas'])->middleware(Autenticacion::class);
Route::post('/vender_producto', [App\Http\Controllers\AdministradorController::class, 'vender_producto'])->middleware(Autenticacion::class);
Route::post('/confirmar_venta', [App\Http\Controllers\AdministradorController::class, 'confirmar_venta'])->middleware(Autenticacion::class);
Route::post('/eliminar_solicitud_venta', [App\Http\Controllers\AdministradorController::class, 'eliminar_solicitud_venta'])->middleware(Autenticacion::class);
Route::post('/agregar_venta', [App\Http\Controllers\AdministradorController::class, 'agregar_venta'])->middleware(Autenticacion::class);
Route::post('/eliminar_venta', [App\Http\Controllers\AdministradorController::class, 'eliminar_venta'])->middleware(Autenticacion::class);
Route::post('/editar_venta', [App\Http\Controllers\AdministradorController::class, 'editar_venta'])->middleware(Autenticacion::class);
Route::post('/editar_venta_confirmar', [App\Http\Controllers\AdministradorController::class, 'editar_venta_confirmar'])->middleware(Autenticacion::class);
Route::post('/buscar_ventas', [App\Http\Controllers\AdministradorController::class, 'buscar_ventas'])->middleware(Autenticacion::class);
Route::get('/sacar_dinero', [App\Http\Controllers\AdministradorController::class, 'sacar_dinero'])->middleware(Autenticacion::class);
Route::post('/sacar_dinero_guardar', [App\Http\Controllers\AdministradorController::class, 'sacar_dinero_guardar'])->middleware(Autenticacion::class);
Route::post('/sacar_dinero_eliminar', [App\Http\Controllers\AdministradorController::class, 'sacar_dinero_eliminar'])->middleware(Autenticacion::class);

//Gastos
Route::get('/gastos', [App\Http\Controllers\GastosController::class, 'index'])->middleware(Autenticacion::class);
Route::post('/guardar_gasto', [App\Http\Controllers\GastosController::class, 'guardar_gasto'])->middleware(Autenticacion::class);
Route::post('/eliminar_gasto', [App\Http\Controllers\GastosController::class, 'eliminar_gasto'])->middleware(Autenticacion::class);

//Usuarios
Route::get('/usuarios', [App\Http\Controllers\UsuariosController::class, 'index'])->middleware(Autenticacion::class);
Route::post('/habilitar_usuario', [App\Http\Controllers\UsuariosController::class, 'habilitar_usuario'])->middleware(Autenticacion::class);
Route::post('/deshabilitar_usuario', [App\Http\Controllers\UsuariosController::class, 'deshabilitar_usuario'])->middleware(Autenticacion::class);
Route::post('/editar_usuario', [App\Http\Controllers\UsuariosController::class, 'editar_usuario'])->middleware(Autenticacion::class);

//Apartados
Route::get('/apartados', [App\Http\Controllers\ApartadosController::class, 'index'])->middleware(Autenticacion::class);

Route::get('/agregar_apartado', [App\Http\Controllers\ApartadosController::class, 'crear_nota'])->middleware(Autenticacion::class);
Route::post('/agregar_apartado', [App\Http\Controllers\ApartadosController::class, 'guardar_nota'])->middleware(Autenticacion::class);

Route::get('/agregar_producto', [App\Http\Controllers\ApartadosController::class, 'crear_producto'])->middleware(Autenticacion::class);
Route::post('/guardar_producto', [App\Http\Controllers\ApartadosController::class, 'guardar_producto'])->middleware(Autenticacion::class);

Route::get('/agregar_abono', [App\Http\Controllers\ApartadosController::class, 'crear_abono'])->middleware(Autenticacion::class);
Route::post('/guardar_abono', [App\Http\Controllers\ApartadosController::class, 'guardar_abono'])->middleware(Autenticacion::class);

Route::post('/agregar_producto_nota', [App\Http\Controllers\ApartadosController::class, 'agregar_producto_nota'])->middleware(Autenticacion::class);
Route::post('/eliminar_producto_nota', [App\Http\Controllers\ApartadosController::class, 'eliminar_producto_nota'])->middleware(Autenticacion::class);
Route::post('/editar_producto_nota', [App\Http\Controllers\ApartadosController::class, 'editar_producto_nota'])->middleware(Autenticacion::class);

Route::post('/agregar_abono_nota', [App\Http\Controllers\ApartadosController::class, 'agregar_abono_nota'])->middleware(Autenticacion::class);
Route::post('/eliminar_abono_nota', [App\Http\Controllers\ApartadosController::class, 'eliminar_abono_nota'])->middleware(Autenticacion::class);
Route::post('/editar_abono_nota', [App\Http\Controllers\ApartadosController::class, 'editar_abono_nota'])->middleware(Autenticacion::class);


Route::post('/editar_nota', [App\Http\Controllers\ApartadosController::class, 'editar_nota'])->middleware(Autenticacion::class);
Route::post('/editar_datos_cliente_nota', [App\Http\Controllers\ApartadosController::class, 'editar_datos_cliente_nota'])->middleware(Autenticacion::class);


// Route::post('/actualizar_nota', [App\Http\Controllers\ApartadosController::class, 'actualizar_nota'])->middleware(Autenticacion::class);
Route::post('/saldar_nota', [App\Http\Controllers\ApartadosController::class, 'saldar_nota'])->middleware(Autenticacion::class);
Route::post('/eliminar_nota', [App\Http\Controllers\ApartadosController::class, 'eliminar_nota'])->middleware(Autenticacion::class);

//Rines
Route::get('/rines', [App\Http\Controllers\RinesController::class, 'index']);
Route::post('/agregar_rin', [App\Http\Controllers\RinesController::class, 'guardar_rin'])->middleware(Autenticacion::class);
Route::post('/eliminar_rin', [App\Http\Controllers\RinesController::class, 'eliminar_rin'])->middleware(Autenticacion::class);
Route::post('/editar_rin', action: [App\Http\Controllers\RinesController::class, 'editar_rin'])->middleware(Autenticacion::class);
Route::get('/buscar_rines', action: [App\Http\Controllers\RinesController::class, 'buscar_rines']);
// Route::get('/buscar_rines', action: [App\Http\Controllers\RinesController::class, 'index']);
