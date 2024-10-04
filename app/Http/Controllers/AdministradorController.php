<?php

namespace App\Http\Controllers;

use App\Models\Cat_Baterias_Guadalupano;
use App\Models\Cat_Baterias_Potreros;
use App\Models\Cat_gastos;
use App\Models\Cat_Llantas_Guadalupano;
use App\Models\Cat_Llantas_Potreros;
use App\Models\Cat_Notas;
use App\Models\Cat_Ventas;
use App\Models\Sacar_Dinero;
use App\Models\User;
use App\Models\View_gastos_detalle;
use App\Models\View_sacar_dinero;
use App\Models\View_ventas_detalle_guadalupano;
use App\Models\View_ventas_detalle_potreros;
use App\Models\vw_dinero_final;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AdministradorController extends Controller
{
    //

    public function index()
    {
        $dinero_final = vw_dinero_final::orderBy('semana')->get();
        $guadalupano = View_ventas_detalle_guadalupano::orderBy('semana')->get();
        $potreros = View_ventas_detalle_potreros::orderBy('semana')->get();
        $numero_usuarios = User::count();
        $numero_notas = Cat_Notas::where('estado', 1)->count();

        return view('Administrador.index', [
            'dinero_final' => $dinero_final,
            'guadalupano' => $guadalupano,
            'potreros' => $potreros,
            'numero_usuarios' => $numero_usuarios,
            'numero_notas' => $numero_notas
        ]);
    }

    public function index_ventas()
    {
        $year = Carbon::now()->year;
        $startOfWeek = Carbon::now()->startOfWeek(); // Lunes de la semana actual
        $endOfWeek = Carbon::now()->endOfWeek(); // Domingo de la semana actual
        // Obtener la fecha actual
        $fechaActual = Carbon::now();
        // Obtener el número de la semana del año
        $numeroSemana = $fechaActual->week;

        // $ventasGuadalupano = Cat_Ventas::where('Tienda', 1)->get();
        // $ventasPotreros = Cat_Ventas::where('Tienda', 0)->get();
        // dd($numeroSemana);
        $dinero_final = vw_dinero_final::where('semana', $numeroSemana)->where('año', $year)->first();

        // dd($dinero_final);
        if (!$dinero_final) {
            $dinero_final = (object) [
                'dinero_final' => 0
            ];
        }

        $detalles_ventas_potreros = View_ventas_detalle_potreros::where('semana', $numeroSemana)->where('ano', $year)->first();
        if (!$detalles_ventas_potreros) {
            $detalles_ventas_potreros = (object) [
                'totalDineroElectronico' => 0,
                'totalEfectivo' => 0,
                'totalPrecioCompra' => 0,
                'totalPrecioVenta' => 0,
                'totalGanancia' => 0
            ];
        }
        $detalles_ventas_guadalupano = View_ventas_detalle_guadalupano::where('semana', $numeroSemana)->where('ano', $year)->first();
        // Proporcionar valores predeterminados si no se encuentran resultados
        if (!$detalles_ventas_guadalupano) {
            $detalles_ventas_guadalupano = (object) [
                'totalDineroElectronico' => 0,
                'totalEfectivo' => 0,
                'totalPrecioCompra' => 0,
                'totalPrecioVenta' => 0,
                'totalGanancia' => 0
            ];
        }

        $gastos_detalle = View_gastos_detalle::where('semana', $numeroSemana)->where('ano', $year)->first();
        if (!$gastos_detalle) {
            $gastos_detalle = (object) [
                'total_gastos' => 0
            ];
        }

        $ventas = Cat_Ventas::whereBetween('fecha', [$startOfWeek, $endOfWeek])
            ->orderBy('estado', 'asc')
            ->orderBy('fecha', 'desc')
            ->get();

        $dinero_sacado = View_sacar_dinero::where('semana', $numeroSemana)->where('ano', $year)->first();

        return view('Administrador.index_ventas', [
            // 'ventasPotreros' => $ventasPotreros,
            // 'ventasGuadalupano' => $ventasGuadalupano,
            'detalles_ventas_potreros' => $detalles_ventas_potreros,
            'detalles_ventas_guadalupano' => $detalles_ventas_guadalupano,
            'ventas' => $ventas,
            'gastos_detalle' => $gastos_detalle,
            'dinero_final' => $dinero_final,
            'dinero_sacado' => $dinero_sacado
        ]);
    }

    public function vender_producto(Request $request)
    {
        $tipo_producto = $request->producto;
        $id_producto = $request->id;

        if ($tipo_producto == "LlantasPotreros") {
            $llanta = Cat_Llantas_Potreros::where('id', $id_producto)->first();

            $venta = new Cat_Ventas();
            $venta->id_recurso = $llanta->id;
            $venta->cantidad = $llanta->Cantidad;
            $venta->descripcion = $llanta->Medida . ' ' . $llanta->Marca;
            $venta->observacion = "";
            $venta->precio_compra = $llanta->PrecioCompra;
            $venta->precio_venta = $llanta->PrecioVenta;
            $venta->forma_pago = 0;
            $venta->tienda = "Potreros";
            $venta->fecha = now()->toDateString();
            $venta->estado = 0;
            $venta->relacion_producto = "LlantasPotreros";
            $validacion = $venta->save();

            if ($validacion) {
                return redirect('llantasP')->with('success', 'Se agrego de forma exitosa a las ventas');
            } else {
                return redirect('llantasP')->with('success', 'Ocurrio algun error');
            }
        }

        if ($tipo_producto == "LlantasGuadalupano") {
            $llanta = Cat_Llantas_Guadalupano::where('id', $id_producto)->first();

            $venta = new Cat_Ventas();
            $venta->id_recurso = $llanta->id;
            $venta->cantidad = $llanta->Cantidad;
            $venta->descripcion = $llanta->Medida . ' ' . $llanta->Marca;
            $venta->observacion = "";
            $venta->precio_compra = $llanta->PrecioCompra;
            $venta->precio_venta = $llanta->PrecioVenta;
            $venta->forma_pago = 0;
            $venta->tienda = "Guadalupano";
            $venta->fecha = now()->toDateString();
            $venta->estado = 0;
            $venta->relacion_producto = "LlantasGuadalupano";
            $validacion = $venta->save();

            if ($validacion) {
                return redirect('llantasG')->with('success', 'Se agrego de forma exitosa a las ventas');
            } else {
                return redirect('llantasG')->with('success', 'Ocurrio algun error');
            }
        }

        if ($tipo_producto == "BateriasPotreros") {
            $bateria = Cat_Baterias_Potreros::where('id', $id_producto)->first();

            $venta = new Cat_Ventas();
            $venta->id_recurso = $bateria->id;
            $venta->cantidad = $bateria->Cantidad;
            $venta->descripcion = $bateria->NoBateria . ' ' . $bateria->Marca;
            $venta->observacion = "";
            $venta->precio_compra = $bateria->PrecioCompra;
            $venta->precio_venta = $bateria->PrecioVenta;
            $venta->forma_pago = 0;
            $venta->tienda = "Potreros";
            $venta->fecha = now()->toDateString();
            $venta->estado = 0;
            $venta->relacion_producto = "BateriasPotreros";
            $validacion = $venta->save();

            if ($validacion) {
                return redirect('bateriasP')->with('success', 'Se agrego de forma exitosa a las ventas');
            } else {
                return redirect('bateriasP')->with('success', 'Ocurrio algun error');
            }
        }

        if ($tipo_producto == "BateriasGuadalupano") {
            $bateria = Cat_Baterias_Guadalupano::where('id', $id_producto)->first();

            $venta = new Cat_Ventas();
            $venta->id_recurso = $bateria->id;
            $venta->cantidad = $bateria->Cantidad;
            $venta->descripcion = $bateria->NoBateria . ' ' . $bateria->Marca;
            $venta->observacion = "";
            $venta->precio_compra = $bateria->PrecioCompra;
            $venta->precio_venta = $bateria->PrecioVenta;
            $venta->forma_pago = 0;
            $venta->tienda = "Guadalupano";
            $venta->fecha = now()->toDateString();
            $venta->estado = 0;
            $venta->relacion_producto = "BateriasGuadalupano";
            $validacion = $venta->save();

            if ($validacion) {
                return redirect('bateriasG')->with('success', 'Se agrego de forma exitosa a las ventas');
            } else {
                return redirect('bateriasG')->with('success', 'Ocurrio algun error');
            }
        }
    }

    public function confirmar_venta(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer',
            'id_recurso' => 'required|integer',
            'cantidad' => 'required|numeric',
            'descripcion' => 'required|string',
            'precio_compra' => 'required|numeric',
            'precio_venta' => 'required|numeric',
            'forma_pago' => 'required|integer',
            'relacion_producto' => 'required|string'
        ]);

        // Extraer los datos del request
        $id = $request->input('id');
        $id_recurso = $request->input('id_recurso');
        $cantidad = $request->input('cantidad');
        $descripcion = $request->input('descripcion');
        $precio_compra = $request->input('precio_compra');
        $precio_venta = $request->input('precio_venta');
        $forma_pago = $request->input('forma_pago');
        $relacion_producto = $request->input('relacion_producto');

        if ($relacion_producto == "LlantasPotreros") {
            $llanta = Cat_Llantas_Potreros::where('id', $id_recurso)->first();
            if ($llanta->Cantidad < $cantidad) {
                return response()->json([
                    'success' => false,
                    'message' => 'La cantidad solicitada supera la cantidad disponible en inventario.'
                ], 400); // Código de estado HTTP 400
            } else {
                //Primero eliminamos del inventario
                $llanta->Cantidad = $llanta->Cantidad - $cantidad;
                if ($llanta->Cantidad == 0) {
                    $llanta->Letra = "-";
                }
                $validar = $llanta->update();

                if ($validar) {
                    $venta = Cat_Ventas::where('id', $id)->first();
                    $venta->estado = 1;
                    $venta->cantidad = $cantidad;
                    $venta->descripcion = $descripcion;
                    // $venta->observacion = "";
                    $venta->precio_compra = $precio_compra * $cantidad;
                    $venta->precio_venta = $precio_venta * $cantidad;
                    $venta->forma_pago = $forma_pago;
                    // $venta->tienda = "Potreros";
                    // $venta->fecha = now()->toDateString();
                    $venta->estado = 1;
                    // $venta->relacion_producto = "LlantasPotreros";
                    $validar = $venta->update();
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'No se pudo actualizar el inventario.'
                    ], 400); // Código de estado HTTP 400
                }
            }
        }

        if ($relacion_producto == "LlantasGuadalupano") {
            $llanta = Cat_Llantas_Guadalupano::where('id', $id_recurso)->first();
            if ($llanta->Cantidad < $cantidad) {
                return response()->json([
                    'success' => false,
                    'message' => 'La cantidad solicitada supera la cantidad disponible en inventario.'
                ], 400); // Código de estado HTTP 400
            } else {
                //Primero eliminamos del inventario
                $llanta->Cantidad = $llanta->Cantidad - $cantidad;
                if ($llanta->Cantidad == 0) {
                    $llanta->Letra = "-";
                }
                $validar = $llanta->update();

                if ($validar) {
                    $venta = Cat_Ventas::where('id', $id)->first();
                    $venta->estado = 1;
                    $venta->cantidad = $cantidad;
                    $venta->descripcion = $descripcion;
                    $venta->precio_compra = $precio_compra * $cantidad;
                    $venta->precio_venta = $precio_venta * $cantidad;
                    $venta->forma_pago = $forma_pago;
                    $venta->estado = 1;
                    $validar = $venta->update();
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'No se pudo actualizar el inventario.'
                    ], 400); // Código de estado HTTP 400
                }
            }
        }

        if ($relacion_producto == "BateriasPotreros") {
            $bateria = Cat_Baterias_Potreros::where('id', $id_recurso)->first();
            if ($bateria->Cantidad < $cantidad) {
                return response()->json([
                    'success' => false,
                    'message' => 'La cantidad solicitada supera la cantidad disponible en inventario.'
                ], 400); // Código de estado HTTP 400
            } else {
                //Primero eliminamos del inventario
                $bateria->Cantidad = $bateria->Cantidad - $cantidad;
                $validar = $bateria->update();

                if ($validar) {
                    $venta = Cat_Ventas::where('id', $id)->first();
                    $venta->estado = 1;
                    $venta->cantidad = $cantidad;
                    $venta->descripcion = $descripcion;
                    $venta->precio_compra = $precio_compra * $cantidad;
                    $venta->precio_venta = $precio_venta * $cantidad;
                    $venta->forma_pago = $forma_pago;
                    $venta->estado = 1;
                    $validar = $venta->update();
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'No se pudo actualizar el inventario.'
                    ], 400); // Código de estado HTTP 400
                }
            }
        }

        if ($relacion_producto == "BateriasGuadalupano") {
            $bateria = Cat_Baterias_Guadalupano::where('id', $id_recurso)->first();
            if ($bateria->Cantidad < $cantidad) {
                return response()->json([
                    'success' => false,
                    'message' => 'La cantidad solicitada supera la cantidad disponible en inventario.'
                ], 400); // Código de estado HTTP 400
            } else {
                //Primero eliminamos del inventario
                $bateria->Cantidad = $bateria->Cantidad - $cantidad;
                $validar = $bateria->update();

                if ($validar) {
                    $venta = Cat_Ventas::where('id', $id)->first();
                    $venta->estado = 1;
                    $venta->cantidad = $cantidad;
                    $venta->descripcion = $descripcion;
                    $venta->precio_compra = $precio_compra * $cantidad;
                    $venta->precio_venta = $precio_venta * $cantidad;
                    $venta->forma_pago = $forma_pago;
                    $venta->estado = 1;
                    $validar = $venta->update();
                } else {
                    return response()->json([
                        'success' => false,
                        'message' => 'No se pudo actualizar el inventario.'
                    ], 400); // Código de estado HTTP 400
                }
            }
        }

        if ($validar) {

            $startOfWeek = Carbon::now()->startOfWeek(); // Lunes de la semana actual
            $endOfWeek = Carbon::now()->endOfWeek(); // Domingo de la semana actual
            // Obtener la fecha actual
            $fechaActual = Carbon::now();
            // Obtener el número de la semana del año
            $numeroSemana = $fechaActual->week;

            $ventas = Cat_Ventas::whereBetween('fecha', [$startOfWeek, $endOfWeek])
                ->orderBy('estado', 'asc')
                ->orderBy('fecha', 'desc')
                ->get();

            // $ventasGuadalupano = Cat_Ventas::where('Tienda', 1)->get();
            // $ventasPotreros = Cat_Ventas::where('Tienda', 0)->get();

            $dinero_final = vw_dinero_final::where('semana', $numeroSemana)->first();
            if (!$dinero_final) {
                $dinero_final = (object) [
                    'dinero_final' => 0
                ];
            }

            $detalles_ventas_potreros = View_ventas_detalle_potreros::where('semana', $numeroSemana)->first();
            if (!$detalles_ventas_potreros) {
                $detalles_ventas_potreros = (object) [
                    'totalEfectivo' => 0,
                    'totalPrecioCompra' => 0,
                    'totalPrecioVenta' => 0,
                    'totalGanancia' => 0
                ];
            }
            $detalles_ventas_guadalupano = View_ventas_detalle_guadalupano::where('semana', $numeroSemana)->first();
            // Proporcionar valores predeterminados si no se encuentran resultados
            if (!$detalles_ventas_guadalupano) {
                $detalles_ventas_guadalupano = (object) [
                    'totalEfectivo' => 0,
                    'totalPrecioCompra' => 0,
                    'totalPrecioVenta' => 0,
                    'totalGanancia' => 0
                ];
            }

            $gastos_detalle = View_gastos_detalle::where('semana', $numeroSemana)->first();
            if (!$gastos_detalle) {
                $gastos_detalle = (object) [
                    'total_gastos' => 0
                ];
            }

            return response()->json([
                'success' => true,
                'message' => 'Actualizado correctamente',
                'ventas' => $ventas,
                'potreros' => $detalles_ventas_potreros,
                'guadalupano' => $detalles_ventas_guadalupano,
                'gastos_detalle' => $gastos_detalle,
                'dinero_final' => $dinero_final
            ]);
        }
    }

    public function eliminar_solicitud_venta(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer',
        ]);

        // Extraer los datos del request
        $id = $request->input('id');
        $venta = Cat_Ventas::where('id', $id)->first();
        $validacion = $venta->delete();
        if ($validacion) {
            $startOfWeek = Carbon::now()->startOfWeek(); // Lunes de la semana actual
            $endOfWeek = Carbon::now()->endOfWeek(); // Domingo de la semana actual
            // Obtener la fecha actual
            $fechaActual = Carbon::now();
            // Obtener el número de la semana del año
            $numeroSemana = $fechaActual->week;

            $ventas = Cat_Ventas::whereBetween('fecha', [$startOfWeek, $endOfWeek])
                ->orderBy('estado', 'asc')
                ->orderBy('fecha', 'desc')
                ->get();

            // $ventasGuadalupano = Cat_Ventas::where('Tienda', 1)->get();
            // $ventasPotreros = Cat_Ventas::where('Tienda', 0)->get();

            $detalles_ventas_potreros = View_ventas_detalle_potreros::where('semana', $numeroSemana)->first();
            if (!$detalles_ventas_potreros) {
                $detalles_ventas_potreros = (object) [
                    'totalEfectivo' => 0,
                    'totalPrecioCompra' => 0,
                    'totalPrecioVenta' => 0,
                    'totalGanancia' => 0
                ];
            }
            $detalles_ventas_guadalupano = View_ventas_detalle_guadalupano::where('semana', $numeroSemana)->first();
            // Proporcionar valores predeterminados si no se encuentran resultados
            if (!$detalles_ventas_guadalupano) {
                $detalles_ventas_guadalupano = (object) [
                    'totalEfectivo' => 0,
                    'totalPrecioCompra' => 0,
                    'totalPrecioVenta' => 0,
                    'totalGanancia' => 0
                ];
            }
            $gastos_detalle = View_gastos_detalle::where('semana', $numeroSemana)->first();
            if (!$gastos_detalle) {
                $gastos_detalle = (object) [
                    'total_gastos' => 0
                ];
            }

            $dinero_final = vw_dinero_final::where('semana', $numeroSemana)->first();
            if (!$dinero_final) {
                $dinero_final = (object) [
                    'dinero_final' => 0
                ];
            }

            return response()->json([
                'success' => true,
                'message' => 'Actualizado correctamente',
                'ventas' => $ventas,
                'potreros' => $detalles_ventas_potreros,
                'guadalupano' => $detalles_ventas_guadalupano,
                'gastos_detalle' => $gastos_detalle,
                'dinero_final' => $dinero_final
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo actualizar eliminar la solicitud de venta.'
            ], 400); // Código de estado HTTP 400
        }
    }

    public function eliminar_venta(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required|integer',
        ]);

        // Extraer los datos del request
        $id = $request->input('id');
        $venta = Cat_Ventas::where('id', $id)->first();
        $validacion = $venta->delete();
        if ($validacion) {
            $startOfWeek = Carbon::now()->startOfWeek(); // Lunes de la semana actual
            $endOfWeek = Carbon::now()->endOfWeek(); // Domingo de la semana actual
            // Obtener la fecha actual
            $fechaActual = Carbon::now();
            // Obtener el número de la semana del año
            $numeroSemana = $fechaActual->week;

            $ventas = Cat_Ventas::whereBetween('fecha', [$startOfWeek, $endOfWeek])
                ->orderBy('estado', 'asc')
                ->orderBy('fecha', 'desc')
                ->get();

            // $ventasGuadalupano = Cat_Ventas::where('Tienda', 1)->get();
            // $ventasPotreros = Cat_Ventas::where('Tienda', 0)->get();

            $detalles_ventas_potreros = View_ventas_detalle_potreros::where('semana', $numeroSemana)->first();
            if (!$detalles_ventas_potreros) {
                $detalles_ventas_potreros = (object) [
                    'totalEfectivo' => 0,
                    'totalPrecioCompra' => 0,
                    'totalPrecioVenta' => 0,
                    'totalGanancia' => 0
                ];
            }
            $detalles_ventas_guadalupano = View_ventas_detalle_guadalupano::where('semana', $numeroSemana)->first();
            // Proporcionar valores predeterminados si no se encuentran resultados
            if (!$detalles_ventas_guadalupano) {
                $detalles_ventas_guadalupano = (object) [
                    'totalEfectivo' => 0,
                    'totalPrecioCompra' => 0,
                    'totalPrecioVenta' => 0,
                    'totalGanancia' => 0
                ];
            }

            $gastos_detalle = View_gastos_detalle::where('semana', $numeroSemana)->first();
            if (!$gastos_detalle) {
                $gastos_detalle = (object) [
                    'total_gastos' => 0
                ];
            }

            $dinero_final = vw_dinero_final::where('semana', $numeroSemana)->first();
            if (!$dinero_final) {
                $dinero_final = (object) [
                    'dinero_final' => 0
                ];
            }

            return response()->json([
                'success' => true,
                'message' => 'Actualizado correctamente',
                'ventas' => $ventas,
                'potreros' => $detalles_ventas_potreros,
                'guadalupano' => $detalles_ventas_guadalupano,
                'gastos_detalle' => $gastos_detalle,
                'dinero_final' => $dinero_final
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No se pudo actualizar eliminar la solicitud de venta.'
            ], 400); // Código de estado HTTP 400
        }
    }

    public function agregar_venta(Request $request)
    {
        $datos = $request->validate([
            'cantidad' => 'required|numeric',
            'descripcion' => 'required|string',
            'precio_compra' => 'required|numeric',
            'precio_venta' => 'required|numeric',
            'forma_pago' => 'required|numeric',
            'tienda' => 'required|string',
            'fecha' => 'required|date',
        ]);

        // Extraer los datos del request
        $cantidad = $request->input('cantidad');
        $descripcion = $request->input('descripcion');
        $precio_compra = $request->input('precio_compra');
        $precio_venta = $request->input('precio_venta');
        $forma_pago = $request->input('forma_pago');
        $tienda = $request->input('tienda');
        $fecha = $request->input('fecha');

        $venta = new Cat_Ventas();
        $venta->estado = 1;
        $venta->cantidad = $cantidad;
        $venta->descripcion = $descripcion;
        $venta->precio_compra = $precio_compra * $cantidad;
        $venta->precio_venta = $precio_venta * $cantidad;
        $venta->forma_pago = $forma_pago;
        $venta->fecha = $fecha;
        $venta->tienda = $tienda;
        $validar = $venta->save();

        if ($validar) {

            $startOfWeek = Carbon::now()->startOfWeek(); // Lunes de la semana actual
            $endOfWeek = Carbon::now()->endOfWeek(); // Domingo de la semana actual
            // Obtener la fecha actual
            $fechaActual = Carbon::now();
            // Obtener el número de la semana del año
            $numeroSemana = $fechaActual->week;

            $ventas = Cat_Ventas::whereBetween('fecha', [$startOfWeek, $endOfWeek])
                ->orderBy('estado', 'asc')
                ->orderBy('fecha', 'desc')
                ->get();

            // $ventasGuadalupano = Cat_Ventas::where('Tienda', 1)->get();
            // $ventasPotreros = Cat_Ventas::where('Tienda', 0)->get();

            $detalles_ventas_potreros = View_ventas_detalle_potreros::where('semana', $numeroSemana)->first();
            if (!$detalles_ventas_potreros) {
                $detalles_ventas_potreros = (object) [
                    'totalEfectivo' => 0,
                    'totalPrecioCompra' => 0,
                    'totalPrecioVenta' => 0,
                    'totalGanancia' => 0
                ];
            }
            $detalles_ventas_guadalupano = View_ventas_detalle_guadalupano::where('semana', $numeroSemana)->first();
            // Proporcionar valores predeterminados si no se encuentran resultados
            if (!$detalles_ventas_guadalupano) {
                $detalles_ventas_guadalupano = (object) [
                    'totalEfectivo' => 0,
                    'totalPrecioCompra' => 0,
                    'totalPrecioVenta' => 0,
                    'totalGanancia' => 0
                ];
            }

            $gastos_detalle = View_gastos_detalle::where('semana', $numeroSemana)->first();
            if (!$gastos_detalle) {
                $gastos_detalle = (object) [
                    'total_gastos' => 0
                ];
            }

            $dinero_final = vw_dinero_final::where('semana', $numeroSemana)->first();
            if (!$dinero_final) {
                $dinero_final = (object) [
                    'dinero_final' => 0
                ];
            }

            return response()->json([
                'success' => true,
                'message' => 'Actualizado correctamente',
                'ventas' => $ventas,
                'potreros' => $detalles_ventas_potreros,
                'guadalupano' => $detalles_ventas_guadalupano,
                'gastos_detalle' => $gastos_detalle,
                'dinero_final' => $dinero_final
            ]);
        }
    }

    public function editar_venta(Request $request)
    {
        $venta = Cat_Ventas::where('id', $request->id)->first();

        return view("Administrador.editar_venta", [
            'venta' => $venta
        ]);
    }

    public function editar_venta_confirmar(Request $request)
    {
        $datos = $request->validate([
            'id' => 'required|numeric',
            'cantidad' => 'required|numeric',
            'descripcion' => 'required|string',
            'precio_compra' => 'required|numeric',
            'precio_venta' => 'required|numeric',
            'forma_pago' => 'required|numeric',
            'tienda' => 'required|string',
            'fecha' => 'required|date',
        ]);

        // Extraer los datos del request
        $cantidad = $request->input('cantidad');
        $descripcion = $request->input('descripcion');
        $precio_compra = $request->input('precio_compra');
        $precio_venta = $request->input('precio_venta');
        $forma_pago = $request->input('forma_pago');
        $tienda = $request->input('tienda');
        $fecha = $request->input('fecha');

        $venta = Cat_Ventas::where('id', $request->id)->first();
        $venta->cantidad = $cantidad;
        $venta->descripcion = $descripcion;
        $venta->precio_compra =  $precio_compra;
        $venta->precio_venta = $precio_venta;
        $venta->forma_pago = $forma_pago;
        $venta->tienda = $tienda;
        $venta->fecha = $fecha;
        $validate = $venta->update();

        if ($validate) {
            return redirect('/ventas')->with('success', 'Venta editada correctamente!');
        } else {
            return redirect('/ventas')->with('error', 'Error al editar la venta');
        }
    }

    public function buscar_ventas(Request $request)
    {
        $validate = $request->validate([
            'date' => 'required|date',
        ]);

        $year = Carbon::now()->year;
        // Convertir la fecha proporcionada en un objeto Carbon
        $date = Carbon::parse($request->date);

        // Extraer solo la parte de la fecha (sin la hora)
        $formattedDate = $date->format('Y-m-d');

        // Calcular el inicio y el final de la semana para la fecha formateada
        $startOfWeek = Carbon::parse($formattedDate)->startOfWeek(Carbon::MONDAY);
        $endOfWeek = Carbon::parse($formattedDate)->endOfWeek(Carbon::SUNDAY);

        $numeroSemana = $date->week;
        // dd($startOfWeek);
        // Obtener las ventas dentro de la semana calculada
        $ventas = Cat_Ventas::whereBetween('fecha', [$startOfWeek, $endOfWeek])
            ->orderBy('estado', 'asc')
            ->orderBy('fecha', 'desc')
            ->get();

        $gastos = Cat_gastos::whereBetween('fecha', [$startOfWeek, $endOfWeek])
            ->orderBy('estado', 'asc')
            ->orderBy('fecha', 'desc')
            ->get();


        $dinero_final = vw_dinero_final::where('año', $year)
            ->where('semana', $numeroSemana)->first();

        $data = [
            'fecha_inicio' => $startOfWeek,
            'fecha_fin' => $endOfWeek,
            'ventas' => $ventas,
            'gastos' => $gastos,
            'dinero_final' => $dinero_final
        ];

        $pdf = Pdf::loadView('Administrador.pdf_index_ventas', $data);
        return $pdf->download('invoice.pdf');
    }

    public function sacar_dinero()
    {

        $startOfWeek = Carbon::now()->startOfWeek(); // Lunes de la semana actual
        $endOfWeek = Carbon::now()->endOfWeek(); // Domingo de la semana actual

        $dinero = Sacar_Dinero::whereBetween('fecha', [$startOfWeek, $endOfWeek])
            ->orderBy('fecha', 'desc')
            ->get();

        return view('Administrador.index_sacar_dinero', compact('dinero'));
    }

    public function  sacar_dinero_guardar(Request $request)
    {
        $validData = $request->validate([
            'descripcion' => 'required',
            'dinero' => 'required',
            'forma_pago' => 'required',
            'fecha' => 'required'
        ]);

        $sacar_dinero = new Sacar_Dinero();

        $sacar_dinero->descripcion = $validData['descripcion'];
        $sacar_dinero->dinero = $validData['dinero'];
        $sacar_dinero->metodo_pago = $validData['forma_pago'];
        $sacar_dinero->fecha = $validData['fecha'];

        $continuar = $sacar_dinero->save();

        if ($continuar) {
            return redirect('/sacar_dinero')->with('success', "Guardado correctamente");
        }
    }

    public function sacar_dinero_eliminar(Request $request)
    {

        $dinero = Sacar_Dinero::where('id', $request->id_dinero)->first();
        $continuar = $dinero->delete();

        if ($continuar) {
            return redirect('/sacar_dinero')->with('success', "Eliminado correctamente");
        }
    }
}
