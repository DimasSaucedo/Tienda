<?php

namespace App\Http\Controllers;

use App\Models\Cat_Baterias_Guadalupano;
use App\Models\Cat_Baterias_Potreros;
use DB;
use Illuminate\Http\Request;
use Log;

class BateriasController extends Controller
{
    public function store(Request $request)
    {


        $validData = $request->validate([
            "nobateria" => "required",
            "marca" => "required",
            "cantidad" => "nullable",
            "precioCompra" => "required",
            "precioVenta" => "required_if:marca,POWER-CONECTION,OTRA",
            "tienda" => "required"
        ]);

        DB::beginTransaction();

        try {
            $redireccion = "";

            if ($validData['marca'] != 'POWER-CONECTION' && $validData['marca'] != 'OTRA') {
                $precioCompra = $validData['precioCompra'];
                $precioMenos25 = $precioCompra - ($precioCompra * 0.25);
                $precioMenos25y10 = $precioMenos25 - ($precioMenos25 * 0.10);
                $precioCompra = $precioMenos25y10;
                $precioVenta = $precioMenos25y10 * 1.25;
                $precioVentaRedondeado = redondear($precioVenta);
                $precioVenta = $precioVentaRedondeado;
            } else {
                $precioCompra = $validData['precioCompra'];
                $precioVenta = $validData['precioVenta'];
            }

            $data = ([
                "NoBateria" => $validData["nobateria"],
                "Marca" => $validData["marca"],
                "Cantidad" => empty($validData['cantidad']) ? 0 : $validData['cantidad'],
                "PrecioCompra" => $precioCompra,
                "PrecioVenta" => $precioVenta,
            ]);

            if ($validData["tienda"] == "potreros") {
                Cat_Baterias_Potreros::create($data);
                $redireccion = "bateriasP";

            } elseif ($validData["tienda"] == "guadalupano") {
                Cat_Baterias_Guadalupano::create($data);
                $redireccion = "bateriasG";
            }

            DB::commit();

            return redirect($redireccion)->with('success', 'Bateria agregada con éxito!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return back()->with("error", $e->getMessage());
        }
    }

    public function update(Request $request)
    {
        // Validar los datos
        $validData = $request->validate([
            "nobateria" => "required",
            "marca" => "required",
            "cantidad" => "nullable",
            "precioCompra" => "required",
            "precioVenta" => "required_if:marca,POWER-CONECTION,OTRA",
            "tienda" => "required",
            "id" => "required"
        ]);

        DB::beginTransaction();

        try {
            $redireccion = "";

            // Buscar el objeto según la tienda
            if ($validData["tienda"] == "potreros") {
                $bateria = Cat_Baterias_Potreros::find($request->id);
            } elseif ($validData["tienda"] == "guadalupano") {
                $bateria = Cat_Baterias_Guadalupano::find($request->id);
            }

            // Variables para los precios
            $precioCompra = $validData['precioCompra'];
            $precioVenta = $validData['precioVenta'];

            // Verificar si el precio de compra ha cambiado
            if ($bateria->PrecioCompra != $validData["precioCompra"]) {
                if ($validData['marca'] != 'POWER-CONECTION' && $validData['marca'] != 'OTRA') {
                    // Si no es una marca especial, aplicar descuentos
                    $precioMenos25 = $precioCompra - ($precioCompra * 0.25);
                    $precioMenos25y10 = $precioMenos25 - ($precioMenos25 * 0.10);
                    $precioCompra = $precioMenos25y10;
                    $precioVenta = $precioMenos25y10 * 1.25;
                    $precioVenta = redondear($precioVenta);
                } else {
                    // Si es una marca especial, tomar los precios directamente
                    $precioCompra = $validData['precioCompra'];
                    $precioVenta = $validData['precioVenta'];
                }
            }

            // Actualizar solo si la batería fue encontrada
            if ($bateria) {
                // Verificar y actualizar solo los campos modificados
                $bateria->update([
                    "NoBateria" => $validData["nobateria"],
                    "Marca" => $validData["marca"],
                    "Cantidad" => empty($validData['cantidad']) ? 0 : $validData['cantidad'],
                    "PrecioCompra" => $precioCompra,
                    "PrecioVenta" => $precioVenta,
                ]);

                // Determinar la redirección basada en la tienda
                $redireccion = $validData["tienda"] == "potreros" ? "bateriasP" : "bateriasG";
            }

            DB::commit();

            // Redirigir con mensaje de éxito
            return redirect($redireccion)->with('success', 'Batería actualizada con éxito!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return back()->with("error", $e->getMessage());
        }
    }

    public function delete(Request $request)
    {
        $validData = $request->validate([
            'id' => "required",
            'tienda' => "required"
        ]);

        DB::beginTransaction();

        try {
            $redireccion = "";

            // Buscar el objeto según la tienda
            if ($validData["tienda"] == "potreros") {
                $bateria = Cat_Baterias_Potreros::find($validData['id']);
            } elseif ($validData["tienda"] == "guadalupano") {
                $bateria = Cat_Baterias_Guadalupano::find($validData['id']);
            }

            $bateria->delete();

            // Determinar la redirección basada en la tienda
            $redireccion = $validData["tienda"] == "potreros" ? "bateriasP" : "bateriasG";

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return back()->with("error", $e->getMessage());
        }
    }
}