@extends('layouts.app')
@section('content')
<link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.css">
<div class="container mt-5">
    <div class="row">
        <div class="col-sm-12 text-center">
            <h1>Ventas</h1>
        </div>
    </div>

    <div class="row mt-5">
        <h4>Historial del ventas</h4>
        <div class="col-sm-9">
            <form action="/buscar_ventas" method="post" novalidate>
                @csrf
                <div class="d-flex">
                    <input type="date" class="form-control me-2" name="date" id="date" required>
                    <button type="submit" class="btn btn-primary">Buscar</button>
                </div>
            </form>
        </div>
        <div class="col-sm-3 text-center">
            <p id="dinero_total" style="font-size: 20px;"><strong>Total de dinero: </strong>
                {{ formatearNumero($dinero_final->dinero_final) }}</p>
        </div>
    </div>
    <div class="container mt-2">
        {{-- Total de dinero en ventas: ${{ $detalles_ventas_potreros->totalPrecioCompra }} --}}
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover" style="width:100%">
                <thead style="background: #e9183b; color: white">
                    <tr>
                        <th>

                        </th>
                        <th class="text-center">
                            Efectivo
                        </th>
                        <th class="text-center">
                            Dinero Electronico
                        </th>
                        <th class="text-center">
                            Inversión de dinero
                        </th>
                        <th class="text-center">
                            Dinero total de ventas
                        </th>
                        <th class="text-center">
                            Ganancia
                        </th>
                        <th class="text-center">
                            Total de gastos
                        </th>
                    </tr>
                </thead>
                <tbody id="body-resumen">
                    <tr>
                        <td>
                            Tienda de potreros
                        </td>
                        <td class="text-center">
                            {{ formatearNumero($detalles_ventas_potreros->totalEfectivo) }}
                        </td>
                        <td class="text-center">
                            {{formatearNumero($detalles_ventas_potreros->totalDineroElectronico)}}
                        </td>
                        <td class="text-center">
                            {{ formatearNumero($detalles_ventas_potreros->totalPrecioCompra) }}
                        </td>
                        <td class="text-center">
                            {{ formatearNumero($detalles_ventas_potreros->totalPrecioVenta) }}
                        </td>
                        <td class="text-center">
                            {{ formatearNumero($detalles_ventas_potreros->totalGanancia) }}
                        </td>
                    </tr>

                    <tr>
                        <td>
                            Tienda del Guadalupano
                        </td>
                        <td class="text-center">
                            {{ formatearNumero($detalles_ventas_guadalupano->totalEfectivo) }}
                        </td>
                        <td class="text-center">
                            {{formatearNumero($detalles_ventas_guadalupano->totalDineroElectronico)}}
                        </td>
                        <td class="text-center">
                            {{ formatearNumero($detalles_ventas_guadalupano->totalPrecioCompra) }}
                        </td>
                        <td class="text-center">
                            {{ formatearNumero($detalles_ventas_guadalupano->totalPrecioVenta) }}
                        </td>
                        <td class="text-center">
                            {{ formatearNumero($detalles_ventas_guadalupano->totalGanancia) }}
                        </td>
                    </tr>
                    <tr>
                        <td>
                            Total
                        </td>
                        @php
                        $ventasTotal =
                        $detalles_ventas_potreros->totalPrecioVenta +
                        $detalles_ventas_guadalupano->totalPrecioVenta;
                        $inversionTotal =
                        $detalles_ventas_potreros->totalPrecioCompra +
                        $detalles_ventas_guadalupano->totalPrecioCompra;
                        $gananciaTotal =
                        $detalles_ventas_potreros->totalGanancia + $detalles_ventas_guadalupano->totalGanancia;
                        $totalEfectivo =
                        $detalles_ventas_potreros->totalEfectivo + $detalles_ventas_guadalupano->totalEfectivo;
                        $totalDineroElectronico = $detalles_ventas_potreros->totalDineroElectronico +
                        $detalles_ventas_guadalupano->totalDineroElectronico
                        @endphp
                        <td class="text-center">
                            {{ formatearNumero($totalEfectivo) }}
                        </td>
                        <td class="text-center">
                            {{formatearNumero($totalDineroElectronico)}}
                        </td>
                        <td class="text-center">
                            {{ formatearNumero($inversionTotal) }}
                        </td>
                        <td class="text-center">
                            {{ formatearNumero($ventasTotal) }}
                        </td>
                        <td class="text-center">
                            {{ formatearNumero($gananciaTotal) }}
                        </td>
                        <td class="text-center">
                            {{ formatearNumero($gastos_detalle->total_gastos) }}
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <a href="/gastos" class="btn btn-success mb-5" style="float: right">Agregar gasto</a>
            </div>
        </div>
        <div class="col-sm-12 mt-2">
            <div class="table-responsive">
                <table id="tabla-ventas" class="table table-striped table-bordered table-hover" style="width:100%">
                    <thead style="background: #e9183b; color: white">
                        <tr>
                            <th class="text-center" hidden>No</th>
                            <th class="text-center" style="width: 40px">Cantidad</th>
                            <th class="text-center" style="width: 250px">Producto</th>
                            <th class="text-center" style="width: 130px">Precio Compra</th>
                            <th class="text-center" style="width: 130px">Precio Venta</th>
                            <th class="text-center">Forma de Pago</th>
                            <th class="text-center">Tienda</th>
                            <th class="text-center">Fecha</th>
                            <th class="text-center">Opciones</th>
                        </tr>
                    </thead>
                    <tbody id="body-ventas">
                        <tr>
                            <form id="form-venta">
                                <td hidden></td>
                                <td><input value="" class="form-control" type="number" id="cantidad" name="cantidad">
                                </td>
                                <td><input value="" class="form-control" id="descripcion" name="descripcion"> </td>
                                <td><input value="" class="form-control" type="number" id="precio_compra"
                                        name="precio_compra" step="0.01"></td>
                                <td><input value="" class="form-control" type="number" id="precio_venta"
                                        name="precio_venta" step="0.01"> </td>
                                <td>
                                    <select class="form-control" name="forma_pago" id="forma_pago">
                                        <option disabled selected value="0">
                                            Selecciona una forma de pago</option>
                                        <option value="1">Tarjeta de
                                            crédito</option>
                                        <option value="2">Tarjeta de
                                            débito</option>
                                        <option value="3">
                                            Transferencia</option>
                                        <option value="4">Efectivo
                                        </option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" id="tienda" name="tienda">
                                        <option disabled selected value="">Selecciona una tienda</option>
                                        <option value="Potreros">Potreros</option>
                                        <option value="Guadalupano">Guadalupano</option>
                                    </select>
                                </td>
                                <td class="text-center"> <input type="date" class="form-control" name="fecha"
                                        id="fecha">
                                </td>
                                <td class="text-center">
                                    <i class="fa-regular fa-square-check" id="guardar-2"
                                        style="color: green; font-size: 25px; cursor:pointer"></i>
                                </td>
                            </form>
                        </tr>
                        @foreach ($ventas as $ve)
                        <tr>
                            @if ($ve->estado == 0)
                            <td class="text-center" hidden>
                                <input hidden value="{{ $ve->id_recurso }}" id="id_recurso" name="id_recurso"
                                    type="number">
                                <input hidden value="{{ $ve->id }}" name="id" id="id" type="number">
                                {{ $ve->id }}
                            </td>
                            <td>
                                <input value="{{ $ve->cantidad }}" class="form-control" type="number" id="cantidad"
                                    name="cantidad">
                            </td>
                            <td>
                                <input value=" {{ $ve->descripcion }}" class="form-control" id="descripcion"
                                    name="descripcion">
                            </td>
                            <td>
                                <input value="{{ $ve->precio_compra }}" class="form-control" type="number"
                                    id="precio_compra" name="precio_compra" step="0.01">
                            </td>
                            <td>
                                <input value="{{ $ve->precio_venta }}" class="form-control" type="number"
                                    id="precio_venta" name="precio_venta" step="0.01">

                            </td>
                            <td>
                                <select class="form-control" name="forma_pago" id="forma_pago">
                                    <option disabled value="0" {{ $ve->forma_pago == 0 ? 'selected' : '' }}>
                                        Selecciona una forma de pago</option>
                                    <option value="1" {{ $ve->forma_pago == 1 ? 'selected' : '' }}>Tarjeta de
                                        crédito</option>
                                    <option value="2" {{ $ve->forma_pago == 2 ? 'selected' : '' }}>Tarjeta de
                                        débito</option>
                                    <option value="3" {{ $ve->forma_pago == 3 ? 'selected' : '' }}>
                                        Transferencia</option>
                                    <option value="4" {{ $ve->forma_pago == 4 ? 'selected' : '' }}>Efectivo
                                    </option>
                                </select>
                            </td>
                            <td class="text-center">
                                <input hidden value="{{ $ve->relacion_producto }}" id="relacion_producto"
                                    name="relacion_producto">
                                {{ $ve->tienda }}
                            </td>
                            <td class="text-center">{{ $ve->fecha }}</td>
                            <td class="text-center">
                                <i class="fa-regular fa-square-check" id="guardar"
                                    style="color: green; font-size: 25px; cursor:pointer"></i>
                                <i class="fa-regular fa-circle-xmark" id="eliminar"
                                    style="color: red; font-size: 25px; cursor:pointer"></i>
                            </td>
                            @else
                            <td class="text-center" hidden>
                                {{ $ve->id }}
                            </td>
                            <td class="text-center">
                                {{ $ve->cantidad }}
                            </td>
                            <td>
                                {{ $ve->descripcion }}
                            </td>
                            <td class="text-center">
                                {{ formatearNumero($ve->precio_compra) }}
                            </td>
                            <td class="text-center">
                                {{ formatearNumero($ve->precio_venta) }}
                            </td>
                            <td class="text-center">
                                @if ($ve->forma_pago == 1)
                                Tarjeta de credito
                                @endif
                                @if ($ve->forma_pago == 2)
                                Tarjeta de débito
                                @endif
                                @if ($ve->forma_pago == 3)
                                Transferencia
                                @endif
                                @if ($ve->forma_pago == 4)
                                Efectivo
                                @endif
                            </td>
                            <td class="text-center">{{ $ve->tienda }}</td>
                            <td class="text-center">{{ $ve->fecha }}</td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-primary dropdown-toggle"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-gear"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <form action="/editar_venta" method="POST">
                                                    @csrf
                                                    <input hidden id="id" name="id" value="{{ $ve->id }}">
                                                    <button type="submit" class="dropdown-item">Editar</button>
                                                </form>
                                            </li>
                                            <li>
                                                <input hidden id="id" name="id" value="{{ $ve->id }}">
                                                <button class="dropdown-item" id="eliminar-venta">Eliminar</button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </td>
                            @endif
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <br>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.dataTables.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<script>
    // Obtiene la fecha de hoy en el formato YYYY-MM-DD
        const today = new Date().toISOString().split('T')[0];
        
        // Establece el valor del input con la fecha de hoy
        document.getElementById('fecha').value = today;
</script>
<script>
    $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#tabla-ventas').DataTable({
                responsive: true,
                dom: 'Blfrtip',
                stateSave: true,
                language: {
                    "url": "/assets/lib/datatable/es.json"
                },
                paging: false,
                ordering: false
            });

            $('#guardar-2').click(function() {
                // Evita el envío del formulario tradicional
                event.preventDefault();

                // Serializa los datos del formulario
                var formData = $('#form-venta').serialize();

                // Muestra mensaje de carga
                Swal.fire({
                    title: 'Cargando...',
                    text: 'Por favor, espere mientras procesamos su solicitud.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                // Enviar solicitud AJAX
                $.ajax({
                    url: '/agregar_venta', // Cambia esto a tu endpoint real
                    type: 'POST',
                    data: formData,
                    success: function(response) {
                        // Cierra el mensaje de carga
                        Swal.close();

                        // Muestra mensaje de éxito
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: response.message || 'Operación exitosa',
                            confirmButtonText: 'Aceptar'
                        }).then(() => {
                            window.location.reload();
                            // Actualiza la tabla o realiza otras acciones necesarias
                            //actualizarTabla(response.ventas);
                            //actualizarResumenTabla(response.potreros, response
                            //    .guadalupano, response.gastos_detalle);
                            //$('#dinero_total').text('Total de dinero: ' +
                            //    formatearNumero(response
                            //        .dinero_final.dinero_final));
                        });
                    },
                    error: function(xhr) {
                        // Cierra el mensaje de carga
                        Swal.close();

                        // Muestra mensaje de error
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON.message || 'Error en la solicitud',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                });
            });


            $('#body-ventas').on('click', '#eliminar-venta', function() {

                var row = $(this).closest('tr');
                var id = parseInt(row.find('#id').val(), 10); // Convertir a entero

                console.log(id);
                console.log(typeof(id));

                Swal.fire({
                    icon: 'warning',
                    title: '¿Desea eliminar esta venta?',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: 'Aceptar',
                    denyButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Mostrar el mensaje de carga
                        Swal.fire({
                            title: 'Cargando...',
                            text: 'Por favor, espere mientras procesamos su solicitud.',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        $.ajax({
                            url: '/eliminar_venta', // URL del endpoint al que haces la solicitud
                            type: 'POST', // Tipo de solicitud (GET, POST, PUT, DELETE, etc.)
                            data: {
                                // Datos a enviar en la solicitud
                                id: id,
                            },
                            success: function(response) {
                                // Código a ejecutar si la solicitud es exitosa
                                Swal.close();

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Éxito',
                                    text: response.message ||
                                        'Operación exitosa',
                                    confirmButtonText: 'Aceptar'
                                }).then(() => {
                                    window.location.reload();
                                    // actualizarTabla(response.ventas);
                                    // actualizarResumenTabla(response.potreros,
                                    //    response
                                    //    .guadalupano, response
                                    //   .gastos_detalle);
                                    //$('#dinero_total').text(
                                    //    'Total de dinero: ' +
                                    //   formatearNumero(response
                                    //      .dinero_final.dinero_final));
                                });
                            },
                            error: function(xhr, status, error) {
                                Swal.close();

                                // Mostrar mensaje de error
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: xhr.responseJSON.message ||
                                        'Error en la solicitud',
                                    confirmButtonText: 'Aceptar'
                                });
                            }
                        });
                    }
                });

            });

            $('#body-ventas').on('click', '#guardar', function() {

                var row = $(this).closest('tr');
                var id = parseInt(row.find('#id').val(), 10); // Convertir a entero
                var id_recurso = parseInt(row.find('#id_recurso').val(), 10);
                var cantidad = parseInt(row.find('#cantidad').val(), 10);
                var descripcion = row.find('#descripcion').val();
                var precio_compra = parseInt(row.find('#precio_compra').val(), 10);
                var precio_venta = parseInt(row.find('#precio_venta').val(), 10);
                var forma_pago = row.find('#forma_pago').val();
                var relacion_producto = row.find('#relacion_producto').val();

                // Mostrar el mensaje de carga

                Swal.fire({
                    icon: 'warning',
                    title: '¿Desea confirmar esta venta?',
                    allowEscapeKey: false,
                    allowOutsideClick: false,
                    showDenyButton: true,
                    showCancelButton: false,
                    confirmButtonText: 'Aceptar',
                    denyButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            title: 'Cargando...',
                            text: 'Por favor, espere mientras procesamos su solicitud.',
                            allowOutsideClick: false,
                            didOpen: () => {
                                Swal.showLoading();
                            }
                        });

                        $.ajax({
                            url: '/confirmar_venta', // URL del endpoint al que haces la solicitud
                            type: 'POST', // Tipo de solicitud (GET, POST, PUT, DELETE, etc.)
                            data: {
                                // Datos a enviar en la solicitud
                                id: id,
                                id_recurso: id_recurso,
                                cantidad: cantidad,
                                descripcion: descripcion,
                                precio_compra: precio_compra,
                                precio_venta: precio_venta,
                                forma_pago: forma_pago,
                                relacion_producto: relacion_producto
                            },
                            success: function(response) {
                                // Código a ejecutar si la solicitud es exitosa
                                Swal.close();

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Éxito',
                                    text: response.message ||
                                        'Operación exitosa',
                                    confirmButtonText: 'Aceptar'
                                }).then(() => {
                                    window.location.reload();
                                    //                                    actualizarTabla(response.ventas);
                                    //                      actualizarResumenTabla(response.potreros,
                                    //                        response
                                    //                      .guadalupano, response
                                    //                    .gastos_detalle);
                                    //              $('#dinero_total').text(
                                    //                'Total de dinero: ' +
                                    //              formatearNumero(response
                                    //                .dinero_final.dinero_final));
                                });
                            },
                            error: function(xhr, status, error) {
                                Swal.close();

                                // Mostrar mensaje de error
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: xhr.responseJSON.message ||
                                        'Error en la solicitud',
                                    confirmButtonText: 'Aceptar'
                                });
                            }
                        });
                    }
                });


            });


            $('#body-ventas').on('click', '#eliminar', function() {

                var id = $('#id').val();
                var id_recurso = $('#id_recurso').val();
                var cantidad = $('#cantidad').val();
                var descripcion = $('#descripcion').val();
                var precio_compra = $('#precio_compra').val();
                var precio_venta = $('#precio_venta').val();
                var forma_pago = $('#forma_pago').val();
                var relacion_producto = $('#relacion_producto').val();

                // Mostrar el mensaje de carga
                Swal.fire({
                    title: 'Cargando...',
                    text: 'Por favor, espere mientras procesamos su solicitud.',
                    allowOutsideClick: false,
                    didOpen: () => {
                        Swal.showLoading();
                    }
                });

                $.ajax({
                    url: '/eliminar_solicitud_venta', // URL del endpoint al que haces la solicitud
                    type: 'POST', // Tipo de solicitud (GET, POST, PUT, DELETE, etc.)
                    data: {
                        // Datos a enviar en la solicitud
                        id: id,
                    },
                    success: function(response) {
                        // Código a ejecutar si la solicitud es exitosa
                        Swal.close();

                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: response.message || 'Operación exitosa',
                            confirmButtonText: 'Aceptar'
                        }).then(() => {
                            window.location.reload();

                            // actualizarTabla(response.ventas);

                            //$('#dinero_total').text('Total de dinero: ' +
                            //    formatearNumero(response
                            //        .dinero_final.dinero_final));
                        });
                    },
                    error: function(xhr, status, error) {
                        Swal.close();

                        // Mostrar mensaje de error
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: xhr.responseJSON.message || 'Error en la solicitud',
                            confirmButtonText: 'Aceptar'
                        });
                    }
                });
            });

            function actualizarTabla(ventas) {
                let tablaBody = $('#body-ventas'); // Obtén el elemento tbody de la tabla
                tablaBody.empty(); // Vacía el contenido actual

                // Recorre los datos y actualiza el HTML
                let filaInsercion = `<tr>
                                <form id="form-venta">
                                <td hidden></td>
                                <td><input value="" class="form-control" type="number" id="cantidad"
                                        name="cantidad"> </td>
                                <td><input value="" class="form-control" id="descripcion" name="descripcion"> </td>
                                <td><input value="" class="form-control" type="number" id="precio_compra"
                                        name="precio_compra"></td>
                                <td><input value="" class="form-control" type="number" id="precio_venta"
                                        name="precio_venta"> </td>
                                <td>
                                    <select class="form-control" name="forma_pago" id="forma_pago">
                                        <option disabled selected value="0">
                                            Selecciona una forma de pago</option>
                                        <option value="1">Tarjeta de
                                            crédito</option>
                                        <option value="2">Tarjeta de
                                            débito</option>
                                        <option value="3">
                                            Transferencia</option>
                                        <option value="4">Efectivo
                                        </option>
                                    </select>
                                </td>
                                <td>
                                    <select class="form-control" id="tienda" name="tienda">
                                        <option disabled selected value="">Selecciona una tienda</option>
                                        <option value="Potreros">Potreros</option>
                                        <option value="Guadalupano">Guadalupano</option>
                                    </select>
                                </td>
                                <td class="text-center"> <input type="date" class="form-control" name="fecha"
                                        id="fecha"> </td>
                                <td class="text-center">
                                    <i class="fa-regular fa-square-check" id="guardar-2"
                                        style="color: green; font-size: 25px; cursor:pointer"></i>
                                </td>
                            </form>
                            </tr>`;
                tablaBody.append(filaInsercion);
                ventas.forEach(ve => {
                    let formaPagoTexto = obtenerFormaPagoTexto(ve
                        .forma_pago); // Obtén el texto de forma de pago

                    let fila = '<tr>';

                    if (ve.estado == 0) {
                        fila += `
                <td class="text-center" hidden>
                     <input hidden value="${ve.id_recurso}" id="id_recurso" name="id_recurso" type="number">
                    <input hidden value="${ve.id}" name="id" id="id" type="number">
                    ${ve.id}
                </td>
                <td class="text-center"><input value="${ve.cantidad}" class="form-control" type="number" id="cantidad" name="cantidad"></td>
                <td><input value="${ve.descripcion}" class="form-control" id="descripcion" name="descripcion"></td>
                <td class="text-center"><input value="${ve.precio_compra}" class="form-control" type="number" id="precio_compra" name="precio_compra"></td>
                <td class="text-center"><input value="${ve.precio_venta}" class="form-control" type="number" id="precio_venta" name="precio_venta"></td>
                <td class="text-center">
                    <select class="form-control" name="forma_pago" id="forma_pago">
                        <option value="0" ${ve.forma_pago == 0 ? 'selected' : ''}>Selecciona una forma de pago</option>
                        <option value="1" ${ve.forma_pago == 1 ? 'selected' : ''}>Tarjeta de crédito</option>
                        <option value="2" ${ve.forma_pago == 2 ? 'selected' : ''}>Tarjeta de débito</option>
                        <option value="3" ${ve.forma_pago == 3 ? 'selected' : ''}>Transferencia</option>
                        <option value="4" ${ve.forma_pago == 4 ? 'selected' : ''}>Efectivo</option>
                    </select>
                </td>
                <td class="text-center"><input hidden value="${ve.relacion_producto}" id="relacion_producto" name="relacion_producto">${ve.tienda}</td>
                <td class="text-center">${ve.fecha}</td>
                <td class="text-center">
                    <i class="fa-regular fa-square-check" id="guardar" style="color: green; font-size: 25px; cursor:pointer"></i>
                    <i class="fa-regular fa-circle-xmark" id="eliminar" style="color: red; font-size: 25px; cursor:pointer"></i>
                </td>
            `;
                    } else {
                        fila += `
                <td class="text-center" hidden>${ve.id}</td>
                <td class="text-center">${ve.cantidad}</td>
                <td>${ve.descripcion}</td>
                <td class="text-center">${formatearNumero(ve.precio_compra)}</td>
                <td class="text-center">${formatearNumero(ve.precio_venta)}</td>
                <td class="text-center">${formaPagoTexto}</td>
                <td class="text-center">${ve.tienda}</td>
                <td class="text-center">${ve.fecha}</td>
                <td> 
                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-primary dropdown-toggle"
                                data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="fa-solid fa-gear"></i>
                            </button>
                            <ul class="dropdown-menu">
                                <li>
                                    <form action="/editar_venta" method="POST">
                                        @csrf
                                        <input hidden id="id" name="id"
                                            value="${ve.id}">
                                        <button type="submit" class="dropdown-item">Editar</button>
                                    </form>
                                </li>
                                <li>
                                    <input hidden id="id" name="id"
                                        value="${ve.id}">
                                    <button class="dropdown-item"
                                        id="eliminar-venta">Eliminar</button>
                                </li>
                            </ul>
                        </div>
                    </div>                         
                </td>
            `;
                    }

                    fila += '</tr>';
                    tablaBody.append(fila); // Añade la nueva fila a la tabla
                });
            }

            function actualizarResumenTabla(detallesVentasPotreros, detallesVentasGuadalupano, gastos_detalle) {
                let tablaBodyResumen = $('#body-resumen'); // Obtén el elemento tbody de la tabla
                tablaBodyResumen.empty(); // Vacía el contenido actual

                // Datos para la primera fila (Tienda de potreros)
                let filaPotreros = `
                    <tr>
                        <td>Tienda de potreros</td>
                        <td>${formatearNumero(detallesVentasPotreros.totalEfectivo)}</td>
                        <td>${formatearNumero(detallesVentasPotreros.totalPrecioVenta)}</td>
                        <td>${formatearNumero(detallesVentasPotreros.totalPrecioCompra)}</td>
                        <td>${formatearNumero(detallesVentasPotreros.totalGanancia)}</td>
                    </tr>
                `;

                // Datos para la segunda fila (Tienda del Guadalupano)
                let filaGuadalupano = `
                    <tr>
                        <td>Tienda del Guadalupano</td>
                        <td>${formatearNumero(detallesVentasGuadalupano.totalEfectivo)}</td>
                        <td>${formatearNumero(detallesVentasGuadalupano.totalPrecioVenta)}</td>
                        <td>${formatearNumero(detallesVentasGuadalupano.totalPrecioCompra)}</td>
                        <td>${formatearNumero(detallesVentasGuadalupano.totalGanancia)}</td>
                    </tr>
                `;

                // Calcular los totales
                let efectivoTotal = parseFloat(detallesVentasPotreros.totalEfectivo) + parseFloat(
                    detallesVentasGuadalupano
                    .totalEfectivo);
                let ventasTotal = parseFloat(detallesVentasPotreros.totalPrecioVenta) + parseFloat(
                    detallesVentasGuadalupano
                    .totalPrecioVenta);
                let inversionTotal = parseFloat(detallesVentasPotreros.totalPrecioCompra) + parseFloat(
                    detallesVentasGuadalupano
                    .totalPrecioCompra);
                let gananciaTotal = parseFloat(detallesVentasPotreros.totalGanancia) + parseFloat(
                    detallesVentasGuadalupano
                    .totalGanancia);


                // Datos para la fila de totales
                let filaTotal = `
                    <tr>
                        <td>Total</td>
                        <td>${formatearNumero(efectivoTotal)}</td>
                        <td>${formatearNumero(ventasTotal)}</td>
                        <td>${formatearNumero(inversionTotal)}</td>
                        <td>${formatearNumero(gananciaTotal)}</td>
                         <td class="text-center">
                            ${formatearNumero(gastos_detalle.total_gastos)}
                        </td>
                    </tr>
                `;

                // Añadir las filas a la tabla
                tablaBodyResumen.append(filaPotreros);
                tablaBodyResumen.append(filaGuadalupano);
                tablaBodyResumen.append(filaTotal);
            }




        });
        // Función para formatear números (puedes ajustarla según tus necesidades)
        function formatearNumero(numero) {
            // Convierte el número a flotante y formatea a dos decimales
            let num = parseInt(numero);

            // Añade el símbolo $ al inicio
            num = `$${num}`;

            // Usa una expresión regular para añadir separadores de miles
            return num.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
        }

        function obtenerFormaPagoTexto(forma_pago) {
            switch (forma_pago) {
                case 1:
                    return 'Tarjeta de crédito';
                case 2:
                    return 'Tarjeta de débito';
                case 3:
                    return 'Transferencia';
                case 4:
                    return 'Efectivo';
                default:
                    return ''; // Opcional, para manejar casos no previstos
            }
        }
</script>
@endsection