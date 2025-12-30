<?php

namespace App\Http\Controllers;

use App\Models\Cat_Ventas;
use Illuminate\Http\Request;

class HistorialController extends Controller
{
    //

    public function index(Request $request)
    {
        // Si no viene semana por parámetro, usamos la semana actual
        $semanaSeleccionada = $request->input('semana', semanaActual());
        [$inicioSemana, $finSemana] = explode('|', $semanaSeleccionada);

        // Obtener ventas de esa semana
        $ventas = Cat_Ventas::whereBetween('fecha', [$inicioSemana, $finSemana])->get();

        // Obtener todas las semanas (últimos 3 meses)
        $semanas = mostrarSemanas();

        if ($request->ajax()) {
            return response()->json([
                'ventas' => $ventas
            ]);
        }

        return view('Administrador.index_historial_ventas', compact('ventas', 'semanas', 'semanaSeleccionada'));
    }
}
