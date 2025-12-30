@extends('layouts.app')
@section('content')
    @php
        $semanas = mostrarSemanas();
    @endphp

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <select name="semana" id="selectSemana" class="form-select">
                    @foreach ($semanas as $value => $label)
                        <option value="{{ $value }}" @if ($value == $semanaSeleccionada) selected @endif>
                            {{ $label }}
                        </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-md-12">
                <table class="table table-striped" id="tablaVentas">
                    <thead>
                        <tr>
                            <th class="text-center">Cantidad</th>
                            <th>Descripción</th>
                            <th class="text-center">Precio Compra</th>
                            <th class="text-center">Precio Venta</th>
                            {{-- <th>Forma de Pago</th> --}}
                            <th>Tienda</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($ventas as $venta)
                            <tr>
                                <td class="text-center">{{ $venta->cantidad }}</td>
                                <td>{{ $venta->descripcion }}</td>
                                <td class="text-center">$ {{ $venta->precio_compra }}</td>
                                <td class="text-center">$ {{ $venta->precio_venta }}</td>
                                {{-- <td>{{ $venta->forma_pago }}</td> --}}
                                <td>{{ $venta->tienda }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $('#selectSemana').on('change', function() {
            let semana = $(this).val();

            $.ajax({
                url: "/historial_ventas",
                type: "GET",
                data: {
                    semana: semana
                },
                success: function(response) {
                    // Limpiar tabla
                    let tbody = $('#tablaVentas tbody');
                    tbody.empty();

                    // Llenar con nuevos datos
                    response.ventas.forEach(function(venta) {
                        tbody.append(`
                        <tr>
                            <td class="text-center">${venta.cantidad}</td>
                            <td>${venta.descripcion}</td>
                            <td class="text-center">$ ${venta.precio_compra}</td>
                            <td class="text-center">$ ${venta.precio_venta}</td>
                            
                            <td>${venta.tienda}</td>
                        </tr>
                    `);
                    });
                }
            });
        });
    </script>
@endsection
