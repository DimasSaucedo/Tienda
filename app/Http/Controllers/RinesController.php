<?php

namespace App\Http\Controllers;

use App\Models\Precio_Rines;
use App\Models\Rines;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;

class RinesController extends Controller
{

    private function reglas(): array
    {
        return [
            'rin'          => 'required|integer|between:10,32',
            'ancho'        => 'required|numeric|between:5,15',
            'barrenacion'  => 'required',
            'tipo'         => 'required',
            'precioCompra' => 'required|numeric|min:0',
            'precioVenta'  => 'required|numeric|min:0',
        ];
    }

    private function reglaImagen(bool $requerida = false): string
    {
        return ($requerida ? 'required' : 'nullable') . '|image|mimes:png,jpg,jpeg,webp|max:2048';
    }

    /** Guarda (o reemplaza) la imagen y borra la anterior. Una sola lógica para todo. */
    private function guardarImagenRin(Precio_Rines $precio, UploadedFile $archivo): void
    {
        $rin      = Rines::firstOrNew(['id_precio_rines' => $precio->id, 'estado' => 1]);
        $anterior = $rin->imagen;
        $nueva    = $archivo->store('rines', 'public');

        try {
            $rin->imagen = $nueva;
            $rin->save();
        } catch (\Throwable $e) {
            Storage::disk('public')->delete($nueva); // evita huérfanos
            throw $e;
        }

        if ($anterior) {
            Storage::disk('public')->delete($anterior);
        }
    }

    public function index_precioRinesP()
    {
        $rines = Precio_Rines::with('imagenRin')
            ->where('estado', 1)
            ->orderBy('rin')
            ->orderBy('ancho')
            ->get();

        return view('Rines.index_precio_rinesP', compact('rines'));
    }

    public function guardar_precioRin(Request $request)
    {
        $data = $request->validate($this->reglas() + ['imagen_rin' => $this->reglaImagen()]);
        $data = Arr::except($data, 'imagen_rin') + ['estado' => 1];

        try {
            DB::transaction(function () use ($data, $request) {
                $precio = Precio_Rines::updateOrCreate(
                    Arr::only($data, ['rin', 'ancho', 'barrenacion', 'tipo']),
                    $data
                );

                if ($request->hasFile('imagen_rin')) {
                    $this->guardarImagenRin($precio, $request->file('imagen_rin'));
                }
            });

            return back()->with('success', 'Precio guardado correctamente');
        } catch (\Throwable $e) {
            Log::error('Error al guardar precio de rin', ['mensaje' => $e->getMessage(), 'linea' => $e->getLine()]);
            return back()->with('error', 'Error al guardar el precio del rin')->withInput();
        }
    }

    public function guardarImagen(Request $request, $id)
    {
        $request->validate(['imagen_rin' => $this->reglaImagen(true)]);

        try {
            $precio = Precio_Rines::where('estado', 1)->findOrFail($id);
            $this->guardarImagenRin($precio, $request->file('imagen_rin'));

            return back()->with('success', 'Imagen guardada correctamente');
        } catch (\Throwable $e) {
            Log::error('Error al guardar imagen del rin', ['mensaje' => $e->getMessage()]);
            return back()->with('error', 'No se pudo guardar la imagen');
        }
    }

    public function eliminarImagen($id)
    {
        try {
            $rin = Rines::where('id_precio_rines', $id)->where('estado', 1)->first();

            if (!$rin?->imagen) {
                return back()->with('error', 'Este registro no tiene imagen');
            }

            $ruta        = $rin->imagen;
            $rin->imagen = null;
            $rin->save();

            Storage::disk('public')->delete($ruta); // primero BD, luego archivo

            return back()->with('success', 'Imagen eliminada correctamente');
        } catch (\Throwable $e) {
            Log::error('Error al eliminar imagen del rin', ['mensaje' => $e->getMessage()]);
            return back()->with('error', 'No se pudo eliminar la imagen');
        }
    }

    public function actualizar_precioRin(Request $request, $id)
{
    $data = $request->validate($this->reglas());

    $precio = Precio_Rines::where('estado', 1)->findOrFail($id);

    // Evita que al editar quede igual a otro registro existente
    $duplicado = Precio_Rines::where('estado', 1)
        ->where('id', '!=', $precio->id)
        ->where(Arr::only($data, ['rin', 'ancho', 'barrenacion', 'tipo']))
        ->exists();

    if ($duplicado) {
        return back()
            ->withErrors(['duplicado' => 'Ya existe un precio con ese rin, ancho, barrenación y tipo.'])
            ->withInput();
    }

    try {
        $precio->update($data);

        return back()->with('success', 'Precio actualizado');
    } catch (\Throwable $e) {
        Log::error('Error al actualizar precio de rin', ['mensaje' => $e->getMessage(), 'linea' => $e->getLine()]);

        return back()->with('error', 'No se pudo actualizar el precio')->withInput();
    }
}

public function eliminar_precioRin($id)
{
    Precio_Rines::where('estado', 1)->findOrFail($id)->update(['estado' => 0]);

    return back()->with('success', 'Precio eliminado');
}
}
