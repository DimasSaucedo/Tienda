@extends('layouts.app')
@section('content')

<div class="container mt-5">
    <div class="table-responsive">
        <h2>Dinero gastado</h2>
        <table id="tabla-ventas" class="table table-striped table-bordered table-hover" style="width:100%">
            <thead style="background: #e9183b; color: white">
                <th class="text-center">
                    Descripción
                </th>

                <th class="text-center">
                    Dinero
                </th>
                <th class="text-center">
                    Forma de pago
                </th>
                <th class="text-center">
                    Fecha
                </th>
                <th></th>
            </thead>
            <tbody>
                <tr>
                    <form action="/sacar_dinero_guardar" method="POST" novalidate>
                        @csrf
                        <td class="text-center">
                            <input class="form-control" type="text" id="descripcion" name="descripcion"
                                placeholder="Ingresa una descripción" required>
                        </td>

                        <td class="text-center">
                            <input class="form-control" type="number" id="dinero" name="dinero" step="0.01"
                                placeholder="Ingresa la cantidad" required>
                        </td>
                        <td class="text-center">
                            <select class="form-control" name="forma_pago" id="forma_pago" required>
                                <option disabled value="0">
                                    Selecciona una forma de pago</option>
                                <option value="1">Tarjeta de
                                    crédito</option>
                                <option value="2">Tarjeta de
                                    débito</option>
                                <option value="3">
                                    Transferencia</option>
                                <option value="4" selected>Efectivo
                                </option>
                            </select>
                        </td>
                        <td class="text-center">
                            <input class="form-control" type="date" id="fecha" name="fecha" required>
                        </td>
                        <td class="text-center">
                            <button type="submit" class="btn btn-button"> <i class="fa-regular fa-square-check"
                                    id="guardar" style="color: green; font-size: 25px; cursor:pointer"></i>
                            </button>
                        </td>
                    </form>
                </tr>
                @foreach ($dinero as $item)
                <tr>
                    <td class="text-center">
                        {{$item->descripcion}}
                    </td>

                    <td class="text-center">
                        {{$item->dinero}}
                    </td>
                    <td class="text-center">
                        {{$item->metodo_pago}}
                    </td>
                    <td class="text-center">
                        {{$item->fecha}}
                    </td>
                    <td class="text-center">
                        <form action="/sacar_dinero_eliminar" method="POST">
                            @csrf
                            <input hidden name="id_dinero" id="id_dinero" value="{{$item->id}}">
                            <button type="submit" class="btn btn-danger">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<a href="/ventas" class="btn btn-primary fixed-button">Regresar</a>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    // Obtiene la fecha de hoy en el formato YYYY-MM-DD
            const today = new Date().toISOString().split('T')[0];
            
            // Establece el valor del input con la fecha de hoy
            document.getElementById('fecha').value = today;
</script>
@endsection