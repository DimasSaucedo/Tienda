<?php

use App\Http\Middleware\Autenticacion;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


Auth::routes();

Route::get('/', [App\Http\Controllers\HomeController::class, 'index']);

//Route::get('/home', [App\Http\Controllers\ReporteController::class, 'home']);
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index']);

Route::get('/llantasP', [App\Http\Controllers\PotrerosController::class, 'index'])->middleware(Autenticacion::class);
Route::get('/llantasG', [App\Http\Controllers\GuadalupanoController::class, 'index'])->middleware(Autenticacion::class);
Route::post('/agregarLlanta', [App\Http\Controllers\LlantasController::class, 'store'])->middleware(Autenticacion::class);
Route::post('/eliminarLlanta', [App\Http\Controllers\LlantasController::class, 'delete'])->middleware(Autenticacion::class);
Route::post('/actualizarLlanta', [App\Http\Controllers\LlantasController::class, 'update'])->middleware(Autenticacion::class);

Route::get('/bateriasP', [App\Http\Controllers\PotrerosController::class, 'baterias'])->middleware(Autenticacion::class);
Route::get('/bateriasG', [App\Http\Controllers\GuadalupanoController::class, 'baterias'])->middleware(Autenticacion::class);
Route::post('/agregarBateria', [App\Http\Controllers\BateriasController::class, 'store'])->middleware(Autenticacion::class);
Route::post('/actualizarBateria', [App\Http\Controllers\BateriasController::class, 'update'])->middleware(Autenticacion::class);
Route::post('/eliminarBateria', [App\Http\Controllers\BateriasController::class, 'delete'])->middleware(Autenticacion::class);
Route::post('/cargar_datos_baterias', [App\Http\Controllers\BateriasController::class, 'cargarDatosBaterias'])->middleware(Autenticacion::class);

Route::post('/mover_llanta', [App\Http\Controllers\LlantasController::class, 'mover_llanta'])->middleware(Autenticacion::class);

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
// Route::get('/rines', [App\Http\Controllers\RinesController::class, 'index']);
// Route::post('/agregar_rin', [App\Http\Controllers\RinesController::class, 'guardar_rin'])->middleware(Autenticacion::class);
// Route::post('/eliminar_rin', [App\Http\Controllers\RinesController::class, 'eliminar_rin'])->middleware(Autenticacion::class);
// Route::post('/editar_rin', action: [App\Http\Controllers\RinesController::class, 'editar_rin'])->middleware(Autenticacion::class);
// Route::get('/buscar_rines', action: [App\Http\Controllers\RinesController::class, 'buscar_rines']);
// Route::get('/buscar_rines', action: [App\Http\Controllers\RinesController::class, 'index']);

//Historial de ventas
Route::get('/historial_ventas', [App\Http\Controllers\HistorialController::class, 'index'])->middleware(Autenticacion::class);

//Precio Rines  
Route::middleware(Autenticacion::class)->group(function () {
    Route::get('/precio_rinesP', [App\Http\Controllers\RinesController::class, 'index_precioRinesP']);

    Route::prefix('precio-rines')->name('precio_rines.')->controller(App\Http\Controllers\RinesController::class)->group(function () {
        Route::post('/', 'guardar_precioRin')->name('store');
        Route::put('/{id}', 'actualizar_precioRin')->name('update');
        Route::delete('/{id}', 'eliminar_precioRin')->name('destroy');
        Route::post('/{id}/imagen', 'guardarImagen')->name('imagen.store');
        Route::delete('/{id}/imagen', 'eliminarImagen')->name('imagen.destroy');
    });
});
