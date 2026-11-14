<?php

namespace App\Http\Controllers;

use App\Models\Precio_Rines;
use App\Models\Rines;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Intervention\Image\Format;

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
        // 10 MB: se aceptan fotos de celular porque luego se optimizan
        return ($requerida ? 'required' : 'nullable') . '|image|mimes:png,jpg,jpeg,webp|max:10240';
    }

    /** Optimiza y guarda imagen + miniatura. Devuelve la ruta de la imagen principal. */
    private function optimizarYGuardar(UploadedFile $archivo): string
    {
        $manager = new ImageManager(new Driver());
        $nombre  = Str::uuid() . '.webp';
        $ruta    = "rines/{$nombre}";
        $thumb   = "rines/thumbs/{$nombre}";
        $disco   = Storage::disk('public');

        // Principal: máx. 1600px por lado, sin ampliar, WebP calidad 80
        $principal = $manager->decodePath($archivo->getRealPath())
            ->scaleDown(width: 1600, height: 1600)
            ->encodeUsingFormat(Format::WEBP, quality: 80);

        // Miniatura para la tabla: máx. 400px, calidad 75
        $mini = $manager->decodePath($archivo->getRealPath())
            ->scaleDown(width: 400, height: 400)
            ->encodeUsingFormat(Format::WEBP, quality: 75);

        try {
            $disco->put($ruta, (string) $principal);
            $disco->put($thumb, (string) $mini);
        } catch (\Throwable $e) {
            $disco->delete([$ruta, $thumb]);
            throw $e;
        }

        return $ruta;
    }

    /** Borra la imagen y su miniatura (si existe). */
    private function borrarArchivosImagen(string $ruta): void
    {
        Storage::disk('public')->delete([
            $ruta,
            dirname($ruta) . '/thumbs/' . basename($ruta),
        ]);
    }

    /** Guarda (o reemplaza) la imagen y borra la anterior. */
    private function guardarImagenRin(Precio_Rines $precio, UploadedFile $archivo): void
    {
        $rin      = Rines::firstOrNew(['id_precio_rines' => $precio->id, 'estado' => 1]);
        $anterior = $rin->imagen;
        $nueva    = $this->optimizarYGuardar($archivo);

        try {
            $rin->imagen = $nueva;
            $rin->save();
        } catch (\Throwable $e) {
            $this->borrarArchivosImagen($nueva); // evita huérfanos
            throw $e;
        }

        if ($anterior) {
            $this->borrarArchivosImagen($anterior);
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
                $precio = Precio_Rines::create($data); // siempre crea uno nuevo

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
            Log::error('Error al guardar imagen del rin', ['mensaje' => $e->getMessage(), 'linea' => $e->getLine()]);
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

            $this->borrarArchivosImagen($ruta); // primero BD, luego archivos

            return back()->with('success', 'Imagen eliminada correctamente');
        } catch (\Throwable $e) {
            Log::error('Error al eliminar imagen del rin', ['mensaje' => $e->getMessage()]);
            return back()->with('error', 'No se pudo eliminar la imagen');
        }
    }

    public function actualizar_precioRin(Request $request, $id)
    {
        $data = $request->validate($this->reglas());

        try {
            Precio_Rines::where('estado', 1)->findOrFail($id)->update($data);

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
