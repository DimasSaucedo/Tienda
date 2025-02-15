<?php

namespace App\Http\Controllers;

use App\Models\Cat_Llantas_Guadalupano;
use App\Models\Cat_Llantas_Potreros;
use DB;
use Illuminate\Http\Request;
use Log;

class LlantasController extends Controller
{
    //

    public function store(Request $request)
    {
        $validData = $request->validate([
            "medida" => "required",
            "marca" => "required",
            "cantidad" => "nullable",
            "letra" => "nullable",
            "precioCompra" => "required",
            "precioVenta" => "required",
            "tienda" => "required"
        ]);

        DB::beginTransaction();

        try {
            $redireccion = "";

            if ($validData['tienda'] == 'guadalupano') {
                $data = [
                    'Medida' => $validData['medida'],
                    'Marca' => strtoupper($validData['marca']),
                    'Cantidad' => empty($validData['cantidad']) ? 0 : $validData['cantidad'],
                    'Letra' => empty($validData['letra']) ? '-' : strtoupper($validData['letra']),
                    'PrecioCompra' => $validData['precioCompra'],
                    'PrecioVenta' => $validData['precioVenta']
                ];
                $cat_Llantas_Guadalupano = Cat_Llantas_Guadalupano::create($data);
                $redireccion = "llantasG";

            } elseif ($validData['tienda'] == 'potreros') {
                $data = [
                    'Medida' => $validData['medida'],
                    'Marca' => strtoupper($validData['marca']),
                    'Cantidad' => empty($validData['cantidad']) ? 0 : $validData['cantidad'],
                    'Letra' => empty($validData['letra']) ? '-' : strtoupper($validData['letra']),
                    'PrecioCompra' => $validData['precioCompra'],
                    'PrecioVenta' => $validData['precioVenta']
                ];
                $cat_Llantas_Potreros = Cat_Llantas_Potreros::create($data);
                $redireccion = "llantasP";
            }

            DB::commit();
            return redirect($redireccion)->with('success', 'Llanta agregada con éxito!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return redirect($redireccion)->with('error', 'No se agregó la llanta');
        }
    }

    public function update(Request $request)
    {
        $validData = $this->validate($request, [
            "id" => "required",
            "medida" => "required",
            "marca" => "required",
            "cantidad" => "required",
            "letra" => "nullable",
            "precioCompra" => "required",
            "precioVenta" => "required",
            "tienda" => "required"
        ]);

        DB::beginTransaction();
        try {
            $redireccion = "";

            if ($validData['tienda'] == 'guadalupano') {
                $cat_Llantas_Guadalupano = Cat_Llantas_Guadalupano::find($validData['id']);
                $cat_Llantas_Guadalupano->Medida = $validData['medida'];
                $cat_Llantas_Guadalupano->Marca = strtoupper($validData['marca']);
                $cat_Llantas_Guadalupano->Cantidad = empty($validData['cantidad']) ? 0 : $validData['cantidad'];
                $cat_Llantas_Guadalupano->Letra = empty($validData['letra']) ? '-' : strtoupper($validData['letra']);
                $cat_Llantas_Guadalupano->PrecioCompra = $validData['precioCompra'];
                $cat_Llantas_Guadalupano->PrecioVenta = $validData['precioVenta'];
                $cat_Llantas_Guadalupano->update();
                $redireccion = "llantasG";
            } elseif ($validData['tienda'] == 'potreros') {
                $cat_Llantas_Potreros = Cat_Llantas_Potreros::find($validData['id']);
                $cat_Llantas_Potreros->Medida = $validData['medida'];
                $cat_Llantas_Potreros->Marca = strtoupper($validData['marca']);
                $cat_Llantas_Potreros->Cantidad = empty($validData['cantidad']) ? 0 : $validData['cantidad'];
                $cat_Llantas_Potreros->Letra = empty($validData['letra']) ? '-' : strtoupper($validData['letra']);
                $cat_Llantas_Potreros->PrecioCompra = $validData['precioCompra'];
                $cat_Llantas_Potreros->PrecioVenta = $validData['precioVenta'];
                $cat_Llantas_Potreros->update();
                $redireccion = "llantasP";
            }

            DB::commit();

            return redirect($redireccion)->with('success', 'Llanta actualizada con éxito!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return redirect('llantasP')->with('error', 'No se actualizó la llanta');
        }
    }

    public function delete(Request $request)
    {
        $validData = $this->validate($request, [
            "id" => "required",
            "tienda" => "required"
        ]);

        DB::beginTransaction();
        try {
            $redireccion = "";

            if ($validData['tienda'] == 'guadalupano') {
                $cat_Llantas_Guadalupano = Cat_Llantas_Guadalupano::find($validData['id']);
                $cat_Llantas_Guadalupano->delete();
                $redireccion = "llantasG";
            } elseif ($validData['tienda'] == 'potreros') {
                $cat_Llantas_Potreros = Cat_Llantas_Potreros::find($validData['id']);
                $cat_Llantas_Potreros->delete();
                $redireccion = "llantasP";
            }

            DB::commit();
            return redirect($redireccion)->with('success', 'Llanta eliminada con éxito!');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
            return redirect('llantasP')->with('error', 'No se eliminó la llanta');
        }
    }
}
