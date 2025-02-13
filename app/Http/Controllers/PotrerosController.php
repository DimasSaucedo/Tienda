<?php

namespace App\Http\Controllers;

use App\Models\Cat_Baterias_Potreros;
use App\Models\Cat_Llantas_Potreros;
use App\Models\Cat_Marcas_Baterias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class PotrerosController extends Controller
{
    public function index()
    {
        // $llantasP = Cat_Llantas_Potreros::orderBy(DB::raw('CAST(SUBSTRING_INDEX(Medida, "-", -1) AS UNSIGNED)'))->get();
        $llantasP = Cat_Llantas_Potreros::orderBy(DB::raw('CAST(SUBSTRING_INDEX(Medida, "-", -1) AS UNSIGNED)'))
            ->orderBy(DB::raw('CAST(SUBSTRING_INDEX(Medida, "-", 1) AS UNSIGNED)'))
            ->orderBy(DB::raw('CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(Medida, "-", 2), "-", -1) AS UNSIGNED)'))
            ->get();

        return view('Poteros.llantas', ['llantas' => $llantasP]);
    }

    public function agregarLlanta(Request $request)
    {
        $validate = $request->validate([
            'cantidad' => 'nullable|numeric',
            'letra' => 'nullable|string',
            'medida' => 'required|string',
            'marca' => 'required|string',
            'precioCompra' => 'required|numeric',
            'precioVenta' => 'required|numeric'
        ]);


        $llantaP = new Cat_Llantas_Potreros();

        $llantaP->Medida = $request->medida;
        $llantaP->Marca = strtoupper($request->marca);
        if ($request->letra == null) {
            $llantaP->Letra = "-";
        } else {
            $llantaP->Letra = strtoupper($request->letra);
        }
        if ($request->cantidad == null) {
            $llantaP->Cantidad = 0;
        } else {
            $llantaP->Cantidad = $request->cantidad;
        }
        $llantaP->PrecioCompra = $request->precioCompra;
        $llantaP->PrecioVenta = $request->precioVenta;
        $validacion = $llantaP->save();

        if ($validacion) {
            return redirect('llantasP')->with('success', 'Llanta agregada con éxito!');
        } else {
            return redirect('llantasP')->with('error', 'No se agrego la llanta');
        }
        //$llantasP = Cat_Llantas_Potreros::orderBy(DB::raw('CAST(SUBSTRING_INDEX(Medida, "-", -1) AS UNSIGNED)'))->get();
    }

    public function actualizaLlanta(Request $request)
    {
        $request->validate([
            'medida' => 'required',
            'marca' => 'required',
            'letra' => 'nullable',
            'cantidad' => 'nullable',
            'precioCompra' => 'required|numeric',
            'precioVenta' => 'required|numeric'
        ]);

        $llantaP = Cat_Llantas_Potreros::where('id', $request->id)->first();

        if ($llantaP) {
            $llantaP->Medida = $request->input('medida');
            $llantaP->Marca = strtoupper($request->input('marca'));
            if ($request->letra == null) {
                $llantaP->Letra = "-";
            } else {
                $llantaP->Letra = strtoupper($request->letra);
            }
            if ($request->cantidad == null) {
                $llantaP->Cantidad = 0;
            } else {
                $llantaP->Cantidad = $request->cantidad;
            }
            $llantaP->PrecioCompra = $request->input('precioCompra');
            $llantaP->PrecioVenta = $request->input('precioVenta');
            $llantaP->update();

            return redirect()->back()->with('success', 'Llanta actualizada correctamente.');
        } else {
            return redirect()->back()->with('error', 'Llanta no encontrada.');
        }
    }


    public function eliminarLlanta(Request $request)
    {
        $llantaP = Cat_Llantas_Potreros::where('id', $request->id)->first();

        $llantaP->delete();

        return redirect()->back()->with('success', 'Llanta eliminada correctamente.');
    }

    public function baterias()
    {
        $baterias = Cat_Baterias_Potreros::all();
        $cat_marcas = Cat_Marcas_Baterias::where('estado', 1)->get();

        return view('Poteros.baterias', compact(
            'baterias',
            'cat_marcas'
        ));
    }
    public function agregarBateria(Request $request)
    {
        $request->validate([
            'nobateria' => 'required',
            'marca' => 'required',
            'cantidad' => 'nullable',
            'precioCompra' => 'required|numeric',
        ]);

        $llantaP = new Cat_Baterias_Potreros();
        $llantaP->NoBateria = $request->nobateria;
        $llantaP->Marca = $request->marca;
        $llantaP->Cantidad = $request->cantidad;
        // $llantaP->PrecioCompra = $request->precioCompra;

        if ($request->marca != 'POWER-CONECTION') {
            $precioCompra = $request->precioCompra;
            // Paso 1: Calcular el 25% de precioCompra
            $precioMenos25 = $precioCompra - ($precioCompra * 0.25);
            // Paso 2: Calcular el 10% del resultado anterior y restarlo
            $precioMenos25y10 = $precioMenos25 - ($precioMenos25 * 0.10);
            // Paso 3: Sumar el 25% al resultado final
            $llantaP->PrecioCompra = $precioMenos25y10;
            $precioVenta = $precioMenos25y10 * 1.25;
            $precioVentaRedondeado = redondear($precioVenta);

            $llantaP->PrecioVenta = $precioVentaRedondeado;
        } else {
            $llantaP->PrecioCompra = $request->precioCompra;
            $llantaP->PrecioVenta = $request->precioVenta;
        }
        $llantaP->save();

        //$llantasP = Cat_Llantas_Potreros::orderBy(DB::raw('CAST(SUBSTRING_INDEX(Medida, "-", -1) AS UNSIGNED)'))->get();
        return redirect('/bateriasP')->with('success', 'Bateria agregada con éxito!');
    }

    public function actualizaBateria(Request $request)
    {
        $request->validate([
            'nobateria' => 'required',
            'marca' => 'required',
            'cantidad' => 'nullable',
            'precioCompra' => 'required|numeric',
            'id' => 'required'
        ]);

        $llantaP = Cat_Baterias_Potreros::where('id', $request->id)->first();

        if ($llantaP) {
            $llantaP->NoBateria = $request->input('nobateria');
            $llantaP->Marca = $request->input('marca');

            if ($request->input('cantidad') == null) {
                $llantaP->Cantidad = 0;
            } else {
                $llantaP->Cantidad = $request->input('cantidad');
            }

            if ($request->marca != 'POWER-CONECTION') {
                $precioCompra = $request->precioCompra;
                // Paso 1: Calcular el 25% de precioCompra
                $precioMenos25 = $precioCompra - ($precioCompra * 0.25);
                // Paso 2: Calcular el 10% del resultado anterior y restarlo
                $precioMenos25y10 = $precioMenos25 - ($precioMenos25 * 0.10);
                // Paso 3: Sumar el 25% al resultado final
                $llantaP->PrecioCompra = $precioMenos25y10;
                $precioVenta = $precioMenos25y10 * 1.25;
                $precioVentaRedondeado = redondear($precioVenta);

                $llantaP->PrecioVenta = $precioVentaRedondeado;
            } else {
                $llantaP->PrecioCompra = $request->precioCompra;
                $llantaP->PrecioVenta = $request->precioVenta;
            }
            
            $llantaP->update();

            return redirect()->back()->with('success', 'Bateria actualizada correctamente.');
        } else {
            return redirect()->back()->with('error', 'Bateria no encontrada.');
        }
    }

    public function eliminarBateria(Request $request)
    {
        $llantaP = Cat_Baterias_Potreros::where('id', $request->id)->first();

        $llantaP->delete();

        return redirect()->back()->with('success', 'Bateria eliminada correctamente.');
    }
}
