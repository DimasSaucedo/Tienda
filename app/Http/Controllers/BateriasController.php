<?php

namespace App\Http\Controllers;

use App\Models\Cat_Baterias_Guadalupano;
use App\Models\Cat_Baterias_Potreros;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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

    public function cargarDatosBaterias(Request $request)
    {
        // 1. Validar que se subió un PDF
        $request->validate([
            'archivo' => 'required|file|mimes:pdf|max:10240',
        ]);

        $archivo = $request->file('archivo');
        $rutaTemporal = $archivo->storeAs('temp', 'precios_lth_' . time() . '.pdf', 'local');
        $rutaAbsoluta = storage_path('app/' . $rutaTemporal);

        // 2. Script Python embebido para parsear el PDF
        $pythonScript = $this->getPythonScript();
        $scriptPath   = storage_path('app/temp/parse_lth.py');
        file_put_contents($scriptPath, $pythonScript);

        // 3. Ejecutar el script Python
        $comando    = escapeshellcmd("python3 {$scriptPath} " . escapeshellarg($rutaAbsoluta));
        $salidaJson = shell_exec($comando);

        if (!$salidaJson) {
            return back()->with('error', 'No se pudo procesar el PDF. Verifica que pdfplumber esté instalado (pip install pdfplumber).');
        }

        $baterias = json_decode($salidaJson, true);

        if (!$baterias || !is_array($baterias)) {
            return back()->with('error', 'El PDF no tiene el formato esperado o no se encontraron datos.');
        }

        // 4. Insertar o actualizar en BD
        $actualizadas = 0;
        $nuevas       = 0;

        DB::beginTransaction();
        try {
            foreach ($baterias as $b) {
                $existe = DB::table('baterias')->where('NoBateria', $b['tipo'])->first();

                $datos = [
                    'ca_frio'                   => $b['ca'],
                    'cca_caliente'              => $b['cca'],
                    'capacidad_reserva'         => $b['reserva'],
                    'largo'                     => $b['largo'],
                    'ancho'                     => $b['ancho'],
                    'alto'                      => $b['alto'],
                    'peso_humedo'               => $b['peso_humedo'],
                    'polaridad_izq'             => $b['polaridad_izq'],
                    'polaridad_der'             => $b['polaridad_der'],
                    'precio_sin_acumulador'     => $b['precio_sin_acumulador'],
                    'precio_con_acumulador'     => $b['precio_con_acumulador'],
                    'PrecioCompraSinAcumulador' => $b['PrecioCompraSinAcumulador'],
                    'PrecioVentaSinAcumulador'  => $b['PrecioVentaSinAcumulador'],
                    'PrecioCompra'              => $b['PrecioCompra'],
                    'PrecioVenta'               => $b['PrecioVenta'],
                    'updated_at'                => now(),
                ];

                if ($existe) {
                    // Actualizar SIN tocar Cantidad ni otros campos
                    DB::table('baterias')
                        ->where('NoBateria', $b['tipo'])
                        ->update($datos);
                    $actualizadas++;
                } else {
                    $datos['NoBateria']  = $b['tipo'];
                    $datos['Marca']      = 'LTH';
                    $datos['Cantidad']   = 0;
                    $datos['created_at'] = now();
                    DB::table('baterias')->insert($datos);
                    $nuevas++;
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al cargar baterías: ' . $e->getMessage());
            return back()->with('error', 'Error al guardar en base de datos: ' . $e->getMessage());
        }

        // 5. Limpiar archivos temporales
        @unlink($rutaAbsoluta);
        @unlink($scriptPath);

        $mensaje = "Proceso completado: {$nuevas} baterías nuevas, {$actualizadas} actualizadas.";
        return back()->with('success', $mensaje);
    }

    private function getPythonScript(): string
    {
        return <<<'PYTHON'
            import sys
            import re
            import json
            import math

            try:
                import pdfplumber
            except ImportError:
                print(json.dumps({"error": "pdfplumber no instalado"}))
                sys.exit(1)

            def parse_price(p):
                return float(p.replace(',', '')) if p else None

            def calcular_precios(precio):
                menos10 = precio - (precio * 0.10)
                menos25 = menos10 - (menos10 * 0.25)
                compra  = round(menos25, 2)
                venta   = math.ceil((compra * 1.25) / 10) * 10
                return compra, float(venta)

            def main(pdf_path):
                with pdfplumber.open(pdf_path) as pdf:
                    text = pdf.pages[0].extract_text()

                lines = text.split('\n')

                pattern = (
                    r'^(\S+)\s+'
                    r'(L-[\S ]+?)\s+'
                    r'(\d+)\s+(\d+)\s+(\d+)\s+'
                    r'(\d+)\s+(\d+)\s+(\d+)\s+'
                    r'([\d.]+)\s+'
                    r'\(([+-])\)\s+/\s+\(([+-])\)\s+'
                    r'\$([\d,]+\.\d+)\s+\$([\d,]+\.\d+)\s+'
                    r'\$([\d,]+\.\d+)\s+\$([\d,]+\.\d+)'
                )

                baterias = []
                for line in lines:
                    m = re.match(pattern, line)
                    if not m:
                        continue

                    (bci, tipo, ca, cca, reserva,
                    largo, ancho, alto,
                    peso, pol_izq, pol_der,
                    p_sin_lista, p_sin_iva,
                    p_con_lista, p_con_iva) = m.groups()

                    tipo = tipo.strip()

                    precio_sin_iva = parse_price(p_sin_iva)
                    precio_con_iva = parse_price(p_con_iva)

                    compra_sin, venta_sin = calcular_precios(precio_sin_iva)
                    compra_con, venta_con = calcular_precios(precio_con_iva)

                    baterias.append({
                        'bci'                      : bci,
                        'tipo'                     : tipo,
                        'ca'                       : int(ca),
                        'cca'                      : int(cca),
                        'reserva'                  : int(reserva),
                        'largo'                    : int(largo),
                        'ancho'                    : int(ancho),
                        'alto'                     : int(alto),
                        'peso_humedo'              : float(peso),
                        'polaridad_izq'            : pol_izq,
                        'polaridad_der'            : pol_der,
                        'precio_sin_acumulador'    : int(precio_sin_iva),
                        'precio_con_acumulador'    : int(precio_con_iva),
                        'PrecioCompraSinAcumulador': compra_sin,
                        'PrecioVentaSinAcumulador' : venta_sin,
                        'PrecioCompra'             : compra_con,
                        'PrecioVenta'              : venta_con,
                    })

                print(json.dumps(baterias, ensure_ascii=False))

            if __name__ == '__main__':
                if len(sys.argv) < 2:
                    print(json.dumps([]))
                    sys.exit(1)
                main(sys.argv[1])
            PYTHON;
    }
}
