<?php

namespace App\Http\Controllers;

use App\Models\Cat_Baterias_Guadalupano;
use App\Models\Cat_Llantas_Guadalupano;
use App\Models\Cat_Marcas_Baterias;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GuadalupanoController extends Controller
{
    public function index()
    {
        $llantasP = Cat_Llantas_Guadalupano::orderBy(DB::raw('CAST(SUBSTRING_INDEX(Medida, "-", -1) AS UNSIGNED)'))
            ->orderBy(DB::raw('CAST(SUBSTRING_INDEX(Medida, "-", 1) AS UNSIGNED)'))
            ->orderBy(DB::raw('CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(Medida, "-", 2), "-", -1) AS UNSIGNED)'))
            ->orderBy('Cantidad')
            ->get();

        return view('Guadalupano.llantas', ['llantas' => $llantasP]);
    }

    public function agregarLlanta(Request $request)
    {
        $llantaP = new Cat_Llantas_Guadalupano();
        $llantaP->Medida = $request->medida;
        $llantaP->Marca = $request->marca;
        $llantaP->Letra = $request->letra;
        $llantaP->Cantidad = $request->cantidad;
        $llantaP->PrecioCompra = $request->precioCompra;
        $llantaP->PrecioVenta = $request->precioVenta;
        $llantaP->save();

        //$llantasP = Cat_Llantas_Potreros::orderBy(DB::raw('CAST(SUBSTRING_INDEX(Medida, "-", -1) AS UNSIGNED)'))->get();
        return redirect('llantasG')->with('success', 'Llanta agregada con éxito!');
    }

    public function actualizaLlanta(Request $request)
    {
        $request->validate([
            'medida' => 'required|string',
            'marca' => 'required|string',
            'letra' => 'nullable|string',
            'cantidad' => 'nullable|integer',
            'precioCompra' => 'required|numeric',
            'precioVenta' => 'required|numeric',
        ]);

        $llantaP = Cat_Llantas_Guadalupano::where('id', $request->id)->first();

        if ($llantaP) {
            $llantaP->Medida = $request->input('medida');
            $llantaP->Marca = $request->input('marca');
            $llantaP->Letra = $request->input('letra');
            $llantaP->Cantidad = $request->input('cantidad');
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
        $llantaP = Cat_Llantas_Guadalupano::where('id', $request->id)->first();

        $llantaP->delete();

        return redirect()->back()->with('success', 'Llanta eliminada correctamente.');
    }

    public function baterias()
    {
        $baterias = Cat_Baterias_Guadalupano::orderBy('Cantidad', 'asc')
            ->orderBy('NoBateria', 'asc')
            ->get();
        $cat_marcas = Cat_Marcas_Baterias::where('estado', 1)->get();


        return view('Guadalupano.baterias', compact('baterias', 'cat_marcas'));
    }
    public function agregarBateria(Request $request)
    {

        $validate = $request->validate([
            'cantidad' => 'nullable|numeric',
            'letra' => 'nullable|string',
            'medida' => 'required|string',
            'marca' => 'required|string',
            'precioCompra' => 'required|numeric',
            'precioVenta' => 'required|numeric'
        ]);


        $llantaP = new Cat_Baterias_Guadalupano();
        $llantaP->NoBateria = $request->nobateria;
        $llantaP->Marca = $request->marca;
        $llantaP->Cantidad = $request->cantidad;
        // $llantaP->PrecioCompra = $request->precioCompra;

        if ($request->marca != 'POWER-CONECTION' || $request->marca != 'OTRA') {
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
        return redirect('/bateriasG')->with('success', 'Bateria agregada con éxito!');
    }

    public function actualizaBateria(Request $request)
    {
        $request->validate([
            'nobateria' => 'required|string',
            'marca' => 'required|string',
            'cantidad' => 'nullable|integer',
            'precioCompra' => 'required|numeric'
        ]);

        $llantaP = Cat_Baterias_Guadalupano::where('id', $request->id)->first();

        if ($llantaP) {
            $llantaP->NoBateria = $request->input('nobateria');
            $llantaP->Marca = $request->input('marca');
            $llantaP->Cantidad = $request->input('cantidad');
            // $llantaP->PrecioCompra = $request->input('precioCompra');
            if ($request->marca != 'POWER-CONECTION' || $request->marca != 'OTRA') {
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
        $llantaP = Cat_Baterias_Guadalupano::where('id', $request->id)->first();

        $llantaP->delete();

        return redirect()->back()->with('success', 'Bateria eliminada correctamente.');
    }
}
