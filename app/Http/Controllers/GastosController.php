<?php

namespace App\Http\Controllers;

use App\Models\Cat_gastos;
use Illuminate\Http\Request;
use Carbon\Carbon;

class GastosController extends Controller
{
    //

    public function index()
    {
        $startOfWeek = Carbon::now()->startOfWeek(); // Lunes de la semana actual
        $endOfWeek = Carbon::now()->endOfWeek(); // Domingo de la semana actual
        // Obtener la fecha actual
        $fechaActual = Carbon::now();
        // Obtener el número de la semana del año
        $numeroSemana = $fechaActual->week;

        $gastos = Cat_gastos::whereBetween('fecha', [$startOfWeek, $endOfWeek])
            ->where('estado', 1)
            ->orderBy('fecha', 'desc')
            ->get();

        return view('Administrador.index_gastos', [
            'gastos' => $gastos
        ]);
    }

    public function guardar_gasto(Request $request)
    {
        $validated = $request->validate([
            'descripcion' => 'required|string',
            'dinero' => 'required|numeric',
            'forma_pago' => 'required|integer',
            'tienda' => 'required|string',
            'fecha' => 'required'
        ]);

        $descripcion = $request->input('descripcion');
        $dinero = $request->input('dinero');
        $forma_pago = $request->input('forma_pago');
        $tienda = $request->input('tienda');
        $fecha = $request->input('fecha');

        $gasto = new Cat_gastos();
        $gasto->descripcion = $descripcion;
        $gasto->dinero = $dinero;
        $gasto->forma_pago = $forma_pago;
        $gasto->tienda = $tienda;
        $gasto->fecha = $fecha;
        $gasto->estado = 1;
        $gasto->save();

        $startOfWeek = Carbon::now()->startOfWeek(); // Lunes de la semana actual
        $endOfWeek = Carbon::now()->endOfWeek(); // Domingo de la semana actual
        // Obtener la fecha actual
        $fechaActual = Carbon::now();
        // Obtener el número de la semana del año
        $numeroSemana = $fechaActual->week;

        $gastos = Cat_gastos::whereBetween('fecha', [$startOfWeek, $endOfWeek])
            ->where('estado', 1)
            ->orderBy('fecha', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Actualizado correctamente',
            'gastos' => $gastos
        ]);
    }
}
