<?php

namespace App\Http\Controllers;

use App\Models\Precio_Rines;
use App\Models\Rines;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class RinesController extends Controller
{
    // public function index()
    // {
    //     $rines = Rines::where('estado', 1)
    //         ->orderBy('diametro', 'asc')
    //         ->orderBy('barrenacion', 'asc')
    //         ->paginate(12); // Cambia 12 al número de rines que deseas mostrar por página

    //     return view('Rines.index', compact('rines'));
    // }


    // public function guardar_rin(Request $request)
    // {
    //     $validData = $request->validate([
    //         'foto_principal' => 'required|mimes:png,jpeg,jpg',
    //         'diametro' => 'required',
    //         'ancho' => 'required',
    //         'barrenacion' => 'required',
    //         'foto_secundaria' => 'nullable|mimes:png,jpeg,jpg'
    //     ]);

    //     $rin = new Rines();
    //     $rin->diametro = $validData['diametro'];
    //     $rin->ancho = $validData['ancho'];
    //     $rin->id_rin = rand(1, 10000);
    //     $rin->diametro_ancho = $validData['diametro'] . 'x' . $validData['ancho'];
    //     $rin->barrenacion = $validData['barrenacion'];
    //     $rin->estado = 1;

    //     $continuar = $rin->save();

    //     if ($continuar && $request->hasFile('foto_principal')) {
    //         $archivo = $request->file('foto_principal');

    //         $nombre_documento = $rin->id . '_' . $rin->id_rin . "_p" . "." . $archivo->getClientOriginalExtension();
    //         $destino = public_path('/images/rines/');
    //         $archivo->move($destino, $nombre_documento);
    //         $rin->foto_principal = $nombre_documento;
    //         $continuar = $rin->update();
    //     }

    //     if ($continuar && $request->hasFile('foto_secundaria')) {
    //         $archivo = $request->file('foto_secundaria');

    //         $nombre_documento = $rin->id . '_' . $rin->id_rin . "_s" . "." . $archivo->getClientOriginalExtension();
    //         $destino = public_path('/images/rines/');
    //         $archivo->move($destino, $nombre_documento);
    //         $rin->foto_secundaria = $nombre_documento;
    //         $continuar = $rin->update();
    //     }

    //     if ($continuar) {
    //         return redirect('rines')->with('success', 'Rin agregado con éxito!');
    //     }
    // }

    // public function editar_rin(Request $request)
    // {
    //     $validData = $request->validate([
    //         'foto_principal' => 'nullable|mimes:png,jpeg,jpg',
    //         'diametro' => 'required',
    //         'ancho' => 'required',
    //         'barrenacion' => 'required',
    //         'foto_secundaria' => 'nullable|mimes:png,jpeg,jpg'
    //     ]);

    //     $rin = Rines::findOrFail($request->id);
    //     $rin->diametro = $validData['diametro'];
    //     $rin->ancho = $validData['ancho'];
    //     $rin->id_rin = rand(1, 10000);
    //     $rin->diametro_ancho = $validData['diametro'] . 'x' . $validData['ancho'];
    //     $rin->barrenacion = $validData['barrenacion'];

    //     // Actualiza el rin sin las imágenes primero
    //     $continuar = $rin->update();

    //     // Manejo de la foto principal
    //     if ($continuar && $request->hasFile('foto_principal')) {
    //         $archivo = $request->file('foto_principal');

    //         // Elimina la foto principal anterior si existe
    //         if ($rin->foto_principal && file_exists(public_path('/images/rines/' . $rin->foto_principal))) {
    //             unlink(public_path('/images/rines/' . $rin->foto_principal));
    //         }

    //         $nombre_documento = $rin->id . '_' . $rin->id_rin . "_p" . "." . $archivo->getClientOriginalExtension();
    //         $destino = public_path('/images/rines/');
    //         $archivo->move($destino, $nombre_documento);
    //         $rin->foto_principal = $nombre_documento;
    //         $continuar = $rin->update();
    //     }

    //     // Manejo de la foto secundaria
    //     if ($continuar && $request->hasFile('foto_secundaria')) {
    //         $archivo = $request->file('foto_secundaria');

    //         // Elimina la foto secundaria anterior si existe
    //         if ($rin->foto_secundaria && file_exists(public_path('/images/rines/' . $rin->foto_secundaria))) {
    //             unlink(public_path('/images/rines/' . $rin->foto_secundaria));
    //         }

    //         $nombre_documento = $rin->id . '_' . $rin->id_rin . "_s" . "." . $archivo->getClientOriginalExtension();
    //         $destino = public_path('/images/rines/');
    //         $archivo->move($destino, $nombre_documento);
    //         $rin->foto_secundaria = $nombre_documento;
    //         $continuar = $rin->update();
    //     }

    //     if ($continuar) {
    //         return redirect('rines')->with('success', 'Rin actualizado con éxito!');
    //     }
    // }


    // public function eliminar_rin(Request $request)
    // {

    //     $rin = Rines::findOrFail($request->id);

    //     // Verificar y eliminar la imagen principal si existe
    //     if ($rin->foto_principal) {
    //         $rutaImagenPrincipal = public_path('/images/rines/') . $rin->foto_principal;
    //         if (file_exists($rutaImagenPrincipal)) {
    //             unlink($rutaImagenPrincipal); // Eliminar la imagen principal
    //         }
    //     }

    //     // Verificar y eliminar la imagen secundaria si existe
    //     if ($rin->foto_secundaria) {
    //         $rutaImagenSecundaria = public_path('/images/rines/') . $rin->foto_secundaria;
    //         if (file_exists($rutaImagenSecundaria)) {
    //             unlink($rutaImagenSecundaria); // Eliminar la imagen secundaria
    //         }
    //     }

    //     // Eliminar el registro del rin
    //     $rin->delete();

    //     return response()->json(['success' => true]);
    // }

    // public function buscar_rines(Request $request)
    // {
    //     $query = Rines::query();

    //     // Filtra por diámetro si está seleccionado
    //     if ($request->diametro) {
    //         $query->where('diametro', $request->diametro);
    //     }

    //     // Filtra por barrenaciones si está seleccionado
    //     if ($request->barrenaciones) {
    //         $query->where('barrenacion', 'like', '%' . $request->barrenaciones . '%');
    //     }

    //     // Obtiene los resultados filtrados y paginados
    //     $rines = $query
    //         ->orderBy('barrenacion', 'asc')
    //         ->paginate(12)
    //         ->appends($request->all()); // Agrega los parámetros de búsqueda a los enlaces de paginación

    //     return view('Rines.index', compact('rines'));
    // }

    private function reglas()
    {
        return [
            'rin'          => 'required|integer|between:10,32',
            'ancho' => 'required|numeric|between:5,15',
            'barrenacion' => 'required',
            'tipo' => 'required',
            // 'tienda'       => 'nullable|string|max:255',
            'precioCompra' => 'required',
            'precioVenta'  => 'required',
        ];
    }

    public function index_precioRinesP(Request $request)
    {
        $rines = Precio_Rines::where('estado', 1)
            ->orderBy('rin', 'asc')
            ->orderBy('ancho', 'asc')
            ->get();

        return view('Rines.index_precio_rinesP', compact('rines'));
    }

    public function guardar_precioRin(Request $request)
    {
        try {


            $data = $request->validate($this->reglas());
            $data['estado'] = 1;

            Precio_Rines::updateOrCreate(
                [
                    'rin'         => $data['rin'],
                    'ancho'       => $data['ancho'],
                    'barrenacion' => $data['barrenacion'],
                    'tipo'        => $data['tipo']
                ],
                $data
            );

            return back()->with('success', 'Precio guardado');
        } catch (Exception  $e) {
            Log::error($e->getMessage());
            return back()->with('success', 'Precio guardado');
        }
    }

    public function eliminar_precioRin($id)
    {
        Precio_Rines::findOrFail($id)->update(['estado' => 0]);

        return back()->with('success', 'Precio eliminado');
    }

    public function actualizar_precioRin(Request $request, $id)
    {
        $data = $request->validate($this->reglas());

        // Evita que al editar quede igual a otro registro existente
        $duplicado = Precio_Rines::where('estado', 1)
            ->where('id', '!=', $id)
            ->where('rin', $data['rin'])
            ->where('ancho', $data['ancho'])
            ->where('barrenacion', $data['barrenacion'])
            ->where('tipo', $data['tipo'])
            ->exists();

        if ($duplicado) {
            return back()->withErrors(['duplicado' => 'Ya existe un precio con ese rin, ancho, barrenación y tipo.'])
                ->withInput();
        }

        Precio_Rines::findOrFail($id)->update($data);

        return back()->with('success', 'Precio actualizado');
    }
}
