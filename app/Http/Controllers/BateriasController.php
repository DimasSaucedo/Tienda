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
        $request->validate([
            'archivo' => 'required|file|mimes:pdf|max:10240',
        ]);

        $archivo      = $request->file('archivo');
        $rutaTemporal = $archivo->storeAs('temp', 'precios_lth_' . time() . '.pdf', 'local');
        $rutaAbsoluta = storage_path('app/' . $rutaTemporal);

        $pythonScript = $this->getPythonScript();
        $scriptPath   = storage_path('app/temp/parse_lth.py');
        file_put_contents($scriptPath, $pythonScript);

        $comando    = escapeshellcmd("python3 {$scriptPath} " . escapeshellarg($rutaAbsoluta));
        $salidaJson = shell_exec($comando);

        if (!$salidaJson) {
            return back()->with('error', 'No se pudo procesar el PDF.');
        }

        $baterias = json_decode($salidaJson, true);

        if (!$baterias || !is_array($baterias) || count($baterias) === 0) {
            return back()->with('error', 'El PDF no tiene el formato esperado o no se encontraron datos.');
        }

        // Cargar precios de cascarones de la BD indexados por tipo
        $cascarones = DB::table('cat_tipo_cascaron_bateria')
            ->pluck('precio', 'tipo_cascaron')
            ->toArray();

        $actualizadas = 0;
        $nuevas       = 0;

        DB::beginTransaction();
        try {
            foreach ($baterias as $b) {

                // Obtener precio del cascaron según clasificacion
                $clasificacion  = $b['clasificacion_acumulador'];
                $precioCascaron = isset($cascarones[$clasificacion])
                    ? (float) $cascarones[$clasificacion]
                    : 0;

                // PrecioVentaSinAcumulador = venta normal + precio cascaron
                $ventaSinAcumulador = $b['PrecioVenta'] + $precioCascaron;

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
                    'precio_con_acumulador'     => $b['precio_con_acumulador'],
                    'clasificacion_acumulador'  => $clasificacion,
                    'PrecioCompra'              => $b['PrecioCompra'],
                    'PrecioVenta'               => $b['PrecioVenta'],
                    'PrecioCompraSinAcumulador' => $b['PrecioCompraSinAcumulador'],
                    'PrecioVentaSinAcumulador'  => $ventaSinAcumulador,
                    'updated_at'                => now(),
                ];

                $existe = DB::table('baterias')->where('NoBateria', $b['tipo'])->first();

                if ($existe) {
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
            return back()->with('error', 'Error: ' . $e->getMessage());
        }

        @unlink($rutaAbsoluta);
        @unlink($scriptPath);

        return back()->with('success', "Proceso completado: {$nuevas} nuevas, {$actualizadas} actualizadas.");
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

        # Mapa de clasificacion por tipo de bateria (segun PDF LTH)
        CLASIFICACION_MAP = {
            'L-22F-450'        : 2,
            'L-42-400'         : 2,
            'L-26R-500'        : 2,
            'L-58-575'         : 2,
            'L-NS40-320'       : 1,
            'L-NS40Z-320'      : 1,
            'L-NS40L-340'      : 1,
            'L-44B19-335'      : 1,
            'L-99(LBN1)-400'   : 1,
            'L-24-530'         : 3,
            'L-42-500'         : 2,
            'L-35-575'         : 3,
            'L-24R-530'        : 3,
            'L-75-575'         : 3,
            'L-42R-500'        : 2,
            'L-51R-500'        : 2,
            'L-51R JIS -480'   : 2,
            'L-51-500'         : 2,
            'L-51 JIS -480'    : 2,
            'L-65-800'         : 4,
            'L-75/86-650'      : 3,
            'L-34-600'         : 3,
            'L-41-650'         : 3,
            'L-47(LN2)-550'    : 3,
            'L-58R-575'        : 2,
            'L-27F-520'        : 4,
            'L-34/78-750'      : 3,
            'L-48/91(LN3)-615' : 3,
            'L-27-700'         : 4,
            'L-94R-800'        : 4,
            'L-4-950 AR**'     : 5,
            'L-30H-670'        : 5,
            'L-31P-750 AR**'   : 5,
            'L-31T-750 AR**'   : 5,
            'L-31P-900 AR**'   : 5,
            'L-31T-900 AR**'   : 5,
            'L-4DLT-1000'      : 6,
            'L-4D-1000'        : 7,
            'L-8D-1125 AR**'   : 7,
        }

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

                # Usamos SOLO el precio con acumulador para todo
                precio_con_iva = parse_price(p_con_iva)

                compra, venta = calcular_precios(precio_con_iva)

                clasificacion = CLASIFICACION_MAP.get(tipo, 0)

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
                    'precio_con_acumulador'    : int(precio_con_iva),
                    'clasificacion_acumulador' : clasificacion,
                    'PrecioCompra'             : compra,
                    'PrecioVenta'              : venta,
                    # Sin acumulador tiene misma base, venta se suma en PHP con precio del cascaron
                    'PrecioCompraSinAcumulador': compra,
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
