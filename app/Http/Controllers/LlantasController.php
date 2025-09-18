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

    public function mover_llanta(Request $request)
    {
        DB::beginTransaction();

        try {
            // Determinar clase origen y destino
            $clases = [
                'potreros' => ['origen' => Cat_Llantas_Potreros::class, 'destino' => Cat_Llantas_Guadalupano::class],
                'guadalupano' => ['origen' => Cat_Llantas_Guadalupano::class, 'destino' => Cat_Llantas_Potreros::class],
            ];

            if (!isset($clases[$request->tienda_original])) {
                throw new \Exception('Tienda original inválida.');
            }

            $origenClass = $clases[$request->tienda_original]['origen'];
            $destinoClass = $clases[$request->tienda_original]['destino'];

            // Buscar llanta en origen
            $llanta = $origenClass::findOrFail($request->id);

            // Validar cantidad a mover
            if ($request->cantidad_mover > $llanta->Cantidad) {
                throw new \Exception('La cantidad a mover es mayor que la disponible.');
            }

            // Restar cantidad en origen
            $llanta->Cantidad -= $request->cantidad_mover;
            if ($llanta->Cantidad == 0) {
                $llanta->Letra = "-";
            }
            $llanta->save();

            // Buscar llanta en destino por Marca y Medida
            $llanta_destino = $destinoClass::where('Marca', $request->marca_mover)
                ->where('Medida', $request->medida_mover)
                ->first();

            if ($llanta_destino) {
                // Si existe, solo actualizar la cantidad
                $llanta_destino->Cantidad += $request->cantidad_mover;
                $llanta_destino->save();
            } else {
                // Si no existe, crear nueva llanta
                $llanta_nueva = new $destinoClass();
                $llanta_nueva->Cantidad = $request->cantidad_mover;
                $llanta_nueva->Marca = $request->marca_mover;
                $llanta_nueva->Letra = "-";
                $llanta_nueva->Medida = $request->medida_mover;
                $llanta_nueva->PrecioCompra = $request->precioCompra_mover;
                $llanta_nueva->PrecioVenta = $request->precioVenta_mover;
                $llanta_nueva->save();
            }

            DB::commit();

            // Determinar ruta según tienda destino
            $redirectRoute = $request->tienda_original === 'potreros' ? 'llantasP' : 'llantasG';

            return redirect($redirectRoute)->with('success', 'Llanta movida correctamente');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            $redirectRoute = $request->tienda_original === 'potreros' ? 'llantasP' : 'llantasG';

            return redirect($redirectRoute)->with('error', 'No se movió la llanta: ' . $e->getMessage());
        }
    }
}
