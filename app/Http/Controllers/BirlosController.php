<?php

namespace App\Http\Controllers;

use App\Models\Birlos;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BirlosController extends Controller
{
    public function index_potreros()
    {
        $birlos = Birlos::where('estado', 1)
            ->where('tienda', "Potreros")
            ->orderBy('medida', 'asc')
            ->orderBy('tipo', 'asc')
            ->orderBy('estilo', 'asc')
            ->orderBy('cantidad')
            ->get();

        return view('Poteros.index_birlos', compact('birlos'));
    }

    public function guardar_birlo(Request $request)
    {
        $datos = $this->validate($request, $this->reglas());

        $rutaImagen = null;

        DB::beginTransaction();

        try {
            if ($request->hasFile('imagen')) {
                $rutaImagen = $this->guardarImagenOptimizada($request->file('imagen'));
            }

            $birlo = new Birlos();
            $birlo->cantidad      = $datos['cantidad'];
            $birlo->medida        = $datos['medida'];
            $birlo->tipo          = $datos['tipo'];
            $birlo->estilo        = $datos['estilo'];
            $birlo->precio_compra = $datos['precio_compra'];
            $birlo->precio_venta  = $datos['precio_venta'];
            $birlo->tienda        = $datos['tienda'];
            $birlo->juego         = (int) $datos['es_juego'];
            $birlo->imagen        = $rutaImagen;
            $birlo->estado        = 1;
            $birlo->save();

            DB::commit();

            return redirect($this->rutaTienda($datos['tienda']))
                ->with('success', 'Birlo registrado correctamente.');
        } catch (Exception $e) {
            DB::rollBack();

            // Si la imagen ya se guardó pero falló la BD, no dejamos archivos huérfanos
            if ($rutaImagen) {
                Storage::disk('public')->delete($rutaImagen);
            }

            Log::error($e->getMessage());

            return back()->withInput()->with('error', 'No se pudo guardar el birlo.');
        }
    }

    public function editar_birlo(Request $request)
    {
        $datos = $this->validate($request, array_merge($this->reglas(), [
            "id" => "required",
        ]));

        $rutaNueva = null;
        $rutaVieja = null;

        DB::beginTransaction();

        try {
            $birlo = Birlos::findOrFail($datos['id']);
            $rutaVieja = $birlo->imagen;

            // Solo reemplaza la imagen si subieron una nueva
            if ($request->hasFile('imagen')) {
                $rutaNueva = $this->guardarImagenOptimizada($request->file('imagen'));
                $birlo->imagen = $rutaNueva;
            }

            $birlo->cantidad      = $datos['cantidad'];
            $birlo->medida        = $datos['medida'];
            $birlo->tipo          = $datos['tipo'];
            $birlo->estilo        = $datos['estilo'];
            $birlo->precio_compra = $datos['precio_compra'];
            $birlo->precio_venta  = $datos['precio_venta'];
            $birlo->tienda        = $datos['tienda'];
            $birlo->juego         = (int) $datos['es_juego'];
            $birlo->save();

            DB::commit();

            // Ya con la BD confirmada, borramos la imagen anterior
            if ($rutaNueva && $rutaVieja) {
                Storage::disk('public')->delete($rutaVieja);
            }

            return redirect($this->rutaTienda($datos['tienda']))
                ->with('success', 'Birlo actualizado correctamente.');
        } catch (Exception $e) {
            DB::rollBack();

            // Si falló la BD, no dejamos la imagen nueva huérfana
            if ($rutaNueva) {
                Storage::disk('public')->delete($rutaNueva);
            }

            Log::error($e->getMessage());

            return back()->withInput()->with('error', 'No se pudo actualizar el birlo.');
        }
    }

    public function eliminar_birlo(Request $request)
    {
        $datos = $this->validate($request, [
            'id'     => "required",
            'tienda' => 'required',
        ]);

        $rutaImagen = null;

        DB::beginTransaction();

        try {
            $birlo = Birlos::findOrFail($datos['id']);

            $rutaImagen = $birlo->imagen;

            $birlo->estado = 0;
            $birlo->imagen = null; // el registro queda sin imagen porque el archivo se borra
            $birlo->save();

            DB::commit();

            // Con la BD confirmada, borramos el archivo del disco
            if ($rutaImagen) {
                Storage::disk('public')->delete($rutaImagen);
            }

            return redirect($this->rutaTienda($datos['tienda']))
                ->with('success', 'Birlo eliminado correctamente.');
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());

            return back()->with('error', 'No se pudo eliminar el birlo.');
        }
    }

    private function reglas(): array
    {
        return [
            "cantidad"      => "required|numeric|min:0",
            "medida"        => "required",
            "estilo"        => "required",
            "tipo"          => "required",
            "precio_compra" => "required|numeric|min:0",
            "precio_venta"  => "required|numeric|min:0",
            "tienda"        => "required",
            "es_juego"      => "required|boolean",
            // El navegador ya reduce las fotos de cámara; este límite es solo un respaldo
            "imagen"        => "nullable|image|mimes:jpeg,png,webp|max:15360",
        ];
    }

    private function rutaTienda(string $tienda): string
    {
        return $tienda === "Potreros" ? "birlos_P" : "birlos_G";
    }

    /**
     * Redimensiona (máx. 1200 px por lado), corrige orientación de fotos de celular
     * y guarda en WebP calidad 80. Devuelve la ruta relativa en el disco "public".
     */
    private function guardarImagenOptimizada(UploadedFile $archivo): string
    {
        $maxLado = 1200;
        $calidad = 80;

        // Decodificar una foto grande de celular consume bastante memoria
        @ini_set('memory_limit', '256M');

        $info = @getimagesize($archivo->getRealPath());
        if (!$info) {
            throw new Exception('El archivo no es una imagen válida.');
        }
        if ($info[0] * $info[1] > 60_000_000) {
            throw new Exception('La imagen es demasiado grande.');
        }

        $img = @imagecreatefromstring(file_get_contents($archivo->getRealPath()));
        if (!$img) {
            throw new Exception('No se pudo leer la imagen.');
        }

        // WebP no acepta imágenes de paleta (algunos PNG)
        imagepalettetotruecolor($img);

        // Corregir rotación EXIF (fotos tomadas con el celular)
        if (function_exists('exif_read_data') && $archivo->getMimeType() === 'image/jpeg') {
            $exif = @exif_read_data($archivo->getRealPath());
            $angulos = [3 => 180, 6 => -90, 8 => 90];
            $orientacion = $exif['Orientation'] ?? 1;

            if (isset($angulos[$orientacion])) {
                $rotada = imagerotate($img, $angulos[$orientacion], 0);
                if ($rotada) {
                    imagedestroy($img);
                    $img = $rotada;
                }
            }
        }

        $ancho = imagesx($img);
        $alto  = imagesy($img);
        $escala = min(1, $maxLado / max($ancho, $alto));
        $nuevoAncho = max(1, (int) round($ancho * $escala));
        $nuevoAlto  = max(1, (int) round($alto * $escala));

        // Lienzo nuevo conservando transparencia (PNG)
        $destino = imagecreatetruecolor($nuevoAncho, $nuevoAlto);
        imagealphablending($destino, false);
        imagesavealpha($destino, true);
        imagefill($destino, 0, 0, imagecolorallocatealpha($destino, 0, 0, 0, 127));
        imagecopyresampled($destino, $img, 0, 0, 0, 0, $nuevoAncho, $nuevoAlto, $ancho, $alto);

        ob_start();
        imagewebp($destino, null, $calidad);
        $webp = ob_get_clean();

        imagedestroy($img);
        imagedestroy($destino);

        if (!$webp) {
            throw new Exception('No se pudo optimizar la imagen.');
        }

        $ruta = 'birlos/' . Str::uuid() . '.webp';
        Storage::disk('public')->put($ruta, $webp);

        return $ruta;
    }
}