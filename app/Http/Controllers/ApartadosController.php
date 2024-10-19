<?php

namespace App\Http\Controllers;

use App\Models\Cat_Abonos;
use App\Models\Cat_Apartados;
use App\Models\Cat_Notas;
use App\Models\View_notas_detalle;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ApartadosController extends Controller
{
    //session()->forget('nota_id');

    public function index()
    {
        $notas = Cat_Notas::orderBy('estado', 'desc')
            ->where('estado', '!=', 2)
            ->orderBy('fecha', 'desc')->get();
        $apartados = Cat_Apartados::all();
        $abonos = Cat_Abonos::all();

        return view('Apartados.index', compact('notas', 'apartados', 'abonos'));
    }

    public function crear_nota()
    {
        return view('Apartados.agregar_apartado');
    }

    public function guardar_nota(Request $request)
    {
        $validData = $request->validate([
            'nombre_cliente' => 'required',
            'telefono_cliente' => 'nullable',
            'tienda' => 'required'
        ]);

        $nota = new Cat_Notas();
        $nota->fecha = Carbon::now()->format('Y-m-d');
        $nota->nombre_cliente = $validData['nombre_cliente'];
        $nota->telefono_cliente = $validData['telefono_cliente'];
        $nota->tienda = $validData['tienda'];
        $nota->estado = 1;
        $validar = $nota->save();

        if ($validar) {
            session(['nota_id' => $nota->id]);
            return redirect('/agregar_producto');
        } else {
            return redirect()->back()->with('error', 'No se creo la nota correctamente');
        }
    }

    public function crear_producto()
    {
        $nota_id = session('nota_id');
        return view('Apartados.agregar_producto')->with('nota_id', $nota_id);
    }

    public function guardar_producto(Request $request)
    {
        $validData = $request->validate([
            'cantidad' => 'required|array',
            'productos' => 'required|array',
            'precio_compra' => 'required|array',
            'precio_venta' => 'required|array',
            'nota_id' => 'required'
        ]);

        foreach ($validData['productos'] as $index => $producto) {
            $apartado = new Cat_Apartados();
            $apartado->id_nota = $validData['nota_id'];
            $apartado->cantidad = $validData['cantidad'][$index];
            $apartado->producto = $producto;
            $apartado->precio_compra = $validData['cantidad'][$index] *  $validData['precio_compra'][$index];
            $apartado->precio_venta = $validData['cantidad'][$index] * $validData['precio_venta'][$index];
            $apartado->save();
        }

        session(['nota_id' => $validData['nota_id']]);
        return redirect('/agregar_abono')
            ->with([
                'success' => 'Productos agregados correctamente'
            ]);
    }

    public function crear_abono()
    {
        $nota_id = session('nota_id');
        return view('Apartados.agregar_abono')->with('nota_id', $nota_id);
    }

    public function guardar_abono(Request $request)
    {
        $validData = $request->validate(
            [
                'nota_id' => 'required',
                'abono' => 'required',
                'abono_fecha' => 'required'
            ]
        );

        $abono = new Cat_Abonos();
        $abono->id_nota = $validData['nota_id'];
        $abono->abono = $validData['abono'];
        $abono->fecha = $validData['abono_fecha'];
        $validar = $abono->save();

        if ($validar) {
            session()->forget('nota_id');

            return redirect('/apartados');
        }
    }

    public function editar_nota(Request $request)
    {
        $nota = Cat_Notas::where('id', $request->id_nota)->first();
        $productos = Cat_Apartados::where('id_nota', $request->id_nota)->get();
        $abonos = Cat_Abonos::where('id_nota', $request->id_nota)->get();

        return view('Apartados.editar_nota', compact('nota', 'productos', 'abonos'));
    }

    public function agregar_producto_nota(Request $request)
    {
        $validData = $request->validate([
            'id_nota' => 'required',
            'cantidad' => 'required',
            'productos' => 'required',
            'precio_compra' => 'required',
            'precio_venta' => 'required'
        ]);

        $nota = new Cat_Apartados();
        $nota->id_nota = $validData['id_nota'];
        $nota->cantidad = $validData['cantidad'];
        $nota->producto = $validData['productos'];
        $nota->precio_compra = $validData['cantidad'] * $validData['precio_compra'];
        $nota->precio_venta = $validData['cantidad'] * $validData['precio_venta'];
        $continuar = $nota->save();

        if ($continuar) {
            return response()->json(['message' => 'Producto añadido correctamente']);
        }
        return redirect('/apartados')->with('success', 'Nota Actualizada correctamente');
    }

    public function agregar_abono_nota(Request $request)
    {
        $validData = $request->validate([
            'id_nota' => 'required',
            'abono' => 'required',
            'fecha' => 'required',
        ]);

        $abono = new Cat_Abonos();
        $abono->id_nota = $validData['id_nota'];
        $abono->abono = $validData['abono'];
        $abono->fecha = $validData['fecha'];
        $continuar = $abono->save();

        if ($continuar) {
            return response()->json(['message' => 'Abono añadido correctamente']);
        }
        //return redirect('/apartados')->with('success', 'Nota Actualizada correctamente');
    }

    public function eliminar_producto_nota(Request $request)
    {
        $nota = Cat_Apartados::where('id', $request->id_producto)->first();
        $continuar = $nota->delete();

        if ($continuar) {
            return response()->json(['message' => 'Producto eliminado correctamente']);
        }
        //return redirect('/apartados')->with('success', 'Nota Actualizada correctamente');
    }


    public function eliminar_abono_nota(Request $request)
    {
        $abono = Cat_Abonos::where('id', $request->id_abono)->first();
        $continuar = $abono->delete();

        if ($continuar) {
            return response()->json(['message' => 'Abono eliminado correctamente']);
        }
        //return redirect('/apartados')->with('success', 'Nota Actualizada correctamente');
    }

    public function editar_producto_nota(Request $request)
    {
        $validData = $request->validate([
            'id_producto' => 'required',
            'cantidad' => 'required',
            'producto' => 'required',
            'precio_compra' => 'required',
            'precio_venta' => 'required'
        ]);

        $nota = Cat_Apartados::where('id', $request->id_producto)->first();
        $nota->cantidad = $validData['cantidad'];
        $nota->producto = $validData['producto'];
        if ($nota->precio_compra != $validData['precio_compra']) {
            $nota->precio_compra = $validData['cantidad'] * $validData['precio_compra'];
        }
        if ($nota->precio_venta != $validData['precio_venta']) {
            $nota->precio_venta = $validData['cantidad'] * $validData['precio_venta'];
        }
        $continuar = $nota->update();


        if ($continuar) {
            return response()->json(['message' => 'Producto añadido correctamente']);
        }
        //return redirect('/apartados')->with('success', 'Nota Actualizada correctamente');
    }

    public function editar_abono_nota(Request $request)
    {
        $validData = $request->validate([
            'id_abono' => 'required',
            'abono' => 'required',
            'fecha' => 'required'
        ]);

        $abono = Cat_Abonos::where('id', $request->id_abono)->first();
        $abono->abono = $validData['abono'];
        $abono->fecha = $validData['fecha'];

        $continuar = $abono->update();


        if ($continuar) {
            return response()->json(['message' => 'Abono editado correctamente']);
        }
        //return redirect('/apartados')->with('success', 'Nota Actualizada correctamente');
    }

    public function actualizar_nota(Request $request)
    {
        $validData = $request->validate([
            'id_nota' => 'required',
            'id_producto' => 'nullable|array',
            'id_abono' => 'nullable|array',
            'productos_eliminados' => 'nullable|string',
            'abonos_eliminados' => 'nullable|string',
            'nombre_cliente' => 'required',
            'telefono_cliente' => 'nullable',
            'tienda' => 'required',
            'cantidad' => 'nullable|array',
            'productos' => 'nullable|array',
            'precio_compra' => 'nullable|array',
            'precio_venta' => 'nullable|array',
            'abono' => 'nullable|array',
            'abono_fecha' => 'nullable|array'
        ]);

        $nota = Cat_Notas::where('id', $validData['id_nota'])->first();
        $nota->nombre_cliente = $validData['nombre_cliente'];
        $nota->telefono_cliente = $validData['telefono_cliente'];
        $nota->tienda = $validData['tienda'];
        $nota->estado = 1;
        $nota->update();

        // Eliminar productos
        if (!empty($request->productos_eliminados)) {
            $idsProductosEliminados = explode(',', rtrim($request->productos_eliminados, ','));
            Cat_Apartados::whereIn('id', $idsProductosEliminados)->delete();
        }

        // Eliminar abonos
        if (!empty($request->abonos_eliminados)) {
            $idsAbonosEliminados = explode(',', rtrim($request->abonos_eliminados, ','));
            Cat_Abonos::whereIn('id', $idsAbonosEliminados)->delete();
        }

        // Actualizar productos
        if (!empty($validData['productos'])) {
            foreach ($validData['productos'] as $index => $producto) {
                if ($validData['id_producto'][$index] == "-") {
                    $apartadoNuevo = new Cat_Apartados();
                    $apartadoNuevo->id_nota = $validData['id_nota'];
                    $apartadoNuevo->cantidad = $validData['cantidad'][$index];
                    $apartadoNuevo->producto = $producto;
                    $apartadoNuevo->precio_compra = $validData['cantidad'][$index] * $validData['precio_compra'][$index];
                    $apartadoNuevo->precio_venta = $validData['cantidad'][$index] * $validData['precio_venta'][$index];
                    $apartadoNuevo->save();
                } else {
                    $apartadoExistente = Cat_Apartados::where('id', $validData['id_producto'][$index])->first();
                    $apartadoExistente->cantidad = $validData['cantidad'][$index];
                    $apartadoExistente->producto = $producto;
                    $apartadoExistente->precio_compra = $validData['precio_compra'][$index] * $validData['cantidad'][$index];
                    $apartadoExistente->precio_venta = $validData['precio_venta'][$index] * $validData['cantidad'][$index];
                    $apartadoExistente->update();
                }
            }
        }


        // Actualizar abonos
        if (!empty($validData['abono'])) {
            foreach ($validData['abono'] as $index => $abono) {
                if ($validData['id_abono'][$index] == "-") {
                    $abonoNuevo = new Cat_Abonos();
                    $abonoNuevo->id_nota = $validData['id_nota'];
                    $abonoNuevo->abono = $abono;
                    $abonoNuevo->fecha = $validData['abono_fecha'][$index];
                    $abonoNuevo->save();
                } else {
                    $abonoExistente = Cat_Abonos::where('id', $validData['id_abono'][$index])->first();
                    $abonoExistente->abono = $abono;
                    $abonoExistente->fecha = $validData['abono_fecha'][$index];
                    $abonoExistente->update();
                }
            }
        }

        return redirect('/apartados')->with('success', 'Nota Actualizada correctamente');
    }

    public function saldar_nota(Request $request)
    {
        $nota = Cat_Notas::where('id', $request->id_nota)->first();

        $nota->estado = 0;
        $nota->update();

        return redirect('apartados')->with('success', 'Nota saldada');
    }

    public function eliminar_nota(Request $request)
    {
        $nota = Cat_Notas::where('id', $request->id_nota)->first();

        $nota->estado = 2;
        $nota->update();

        return redirect('apartados')->with('success', 'Nota eliminada');
    }
}
