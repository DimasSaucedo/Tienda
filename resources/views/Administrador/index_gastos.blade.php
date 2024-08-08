@extends('layouts.app')
@section('content')
    <div class="container mt-5">
        <table id="tabla-ventas" class="table table-striped table-bordered table-hover" style="width:100%">
            <thead style="background: #e9183b; color: white">
                <th class="text-center">
                    Descripción
                </th>
                <th class="text-center">
                    Fecha
                </th>
                <th class="text-center">
                    Dinero
                </th>
                <th class="text-center">
                    Forma de pago
                </th>
                <th class="text-center">
                    Tienda
                </th>
                <th></th>
            </thead>
            <tbody>
                <tr>
                    <td class="text-center">
                        <input class="form-control" type="text" id="descripcion" name="descripcion"
                            placeholder="Ingresa una descripción">
                    </td>
                    <td class="text-center">
                        <input class="form-control" type="date" id="fecha" name="fecha">
                    </td>
                    <td class="text-center">
                        <input class="form-control" type="number" id="dinero" name="dinero"
                            placeholder="Ingresa la cantidad">
                    </td>
                    <td class="text-center">
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
                    <td class="text-center">
                        <select class="form-control" id="tienda" name="tienda">
                            <option disabled selected>Selecciona una opcion</option>
                            <option>Guadalupano</option>
                            <option>Potreros</option>
                        </select>
                    </td>
                    <td class="text-center">
                        <i class="fa-regular fa-square-check" id="guardar"
                            style="color: green; font-size: 25px; cursor:pointer"></i>
                    </td>
                </tr>
                @foreach ($gastos as $ga)
                    <tr>
                        <td class="text-center">{{ $ga->descripcion }}</td>
                        <td class="text-center">{{ $ga->fecha }}</td>
                        <td class="text-center">{{ $ga->dinero }}</td>
                        <td class="text-center">
                            @if ($ga->forma_pago == 1)
                                Tarjeta de credito
                            @endif
                            @if ($ga->forma_pago == 2)
                                Tarjeta de débito
                            @endif
                            @if ($ga->forma_pago == 3)
                                Transferencia
                            @endif
                            @if ($ga->forma_pago == 4)
                                Efectivo
                            @endif
                        </td>
                        <td class="text-center">{{ $ga->tienda }}</td>
                        <td class="text-center">
                            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fa-solid fa-gear"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <input hidden id="id" name="id" value="{{ $ga->id }}">
                                            <button class="dropdown-item" id="eliminar-gasto">Eliminar</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('#guardar').click(function() {


                var descripcion = $('#descripcion').val();
                var dinero = $('#dinero').val();
                var fecha = $('#fecha').val();
                var forma_pago = $('#forma_pago').val();
                var tienda = $('#tienda').val();
                // Mostrar el mensaje de carga

                Swal.fire({
                    icon: 'warning',
                    title: '¿Desea guardar este gasto?',
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
                            url: '/guardar_gasto', // URL del endpoint al que haces la solicitud
                            type: 'POST', // Tipo de solicitud (GET, POST, PUT, DELETE, etc.)
                            data: {
                                // Datos a enviar en la solicitud
                                descripcion: descripcion,
                                dinero: dinero,
                                fecha: fecha,
                                forma_pago: forma_pago,
                                tienda: tienda
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
                                    actualizarTabla(response.gastos);
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
        });

        function actualizarTabla(gastos) {
            let tablaBody = $('#body-ventas'); // Obtén el elemento tbody de la tabla
            tablaBody.empty(); // Vacía el contenido actual

            // Recorre los datos y actualiza el HTML
            let filaInsercion = `<tr> <form id="form-venta">
                                </td>
                                <td>
                                    <input value="" class="form-control" type="number" id="cantidad"
                                        name="cantidad">
                                </td>
                                <td>
                                    <input value="" class="form-control" id="descripcion" name="descripcion">
                                </td>
                                <td>
                                    <input value="" class="form-control" type="number" id="precio_compra"
                                        name="precio_compra">
                                </td>
                                <td>
                                    <input value="" class="form-control" type="number" id="precio_venta"
                                        name="precio_venta">
                                </td>
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
                                <td>
                                    <input type="date" class="form-control" name="fecha" id="fecha">
                                </td>
                                <td class="text-center">
                                    <i class="fa-regular fa-square-check" id="guardar-2"
                                        style="color: green; font-size: 25px; cursor:pointer"></i>
                                </td>
                            </form></tr>`;
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
    </script>
@endsection
