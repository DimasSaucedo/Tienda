@extends('layouts.app')
@section('content')
    <div class="container mt-5 p-5 mb-5" style="background: rgba(153, 153, 153, 0.304); border-radius: 10px">
        <h4>Datos del cliente</h4>
        <form action="/editar_datos_cliente_nota" method="POST" novalidate>
            @csrf

            <div class="mb-3">
                {{-- <label for="basic-url" class="form-label">Nombre del cliente</label> --}}
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon3">Nombre del cliente</span>
                    <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente"
                        aria-describedby="basic-addon3 basic-addon4" value="{{ $nota->nombre_cliente }}" required>
                </div>
                {{-- <div class="form-text" id="basic-addon4">Example help text goes outside the input group.</div> --}}
            </div>

            <div class="mb-3">
                {{-- <label for="basic-url" class="form-label">Nombre del cliente</label> --}}
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon3">Telefono del cliente</span>
                    <input type="text" class="form-control" id="telefono_cliente" name="telefono_cliente"
                        aria-describedby="basic-addon3 basic-addon4" value="{{ $nota->telefono_cliente }}">
                </div>
                {{-- <div class="form-text" id="basic-addon4">Example help text goes outside the input group.</div> --}}
            </div>

            <div class="mb-3">
                {{-- <label for="basic-url" class="form-label">Nombre del cliente</label> --}}
                <div class="input-group">
                    <span class="input-group-text" id="basic-addon3">Tienda</span>
                    {{-- <input type="text" class="form-control" id="telefono_cliente" name="telefono_cliente"
                        aria-describedby="basic-addon3 basic-addon4"> --}}
                    <select name="tienda" id="tienda" class="form-control" required>
                        <option value="" disabled selected>Seleccione una opción</option>
                        <option value="Guadalupano" @if ($nota->tienda == 'Guadalupano') selected @endif>Guadalupano</option>
                        <option value="Potreros" @if ($nota->tienda == 'Potreros') selected @endif>Potreros</option>
                    </select>
                </div>
                {{-- <div class="form-text" id="basic-addon4">Example help text goes outside the input group.</div> --}}
            </div>
            <input type="hidden" value="{{ $nota->id }}" id="id_nota" name="id_nota">
            <button type="button" id="editar_datos_cliente" class="btn btn-primary">Guardar datos del cliente</button>
        </form>

        <hr>
        <h4>Productos</h4>
        <div class="table-responsive" style="border-radius: 5px">
            <table class="table table-hover">
                <thead>
                    <tr class="align-middle text-center">
                        <th style="width: 150px">Cantidad</th>
                        <th>Producto</th>
                        <th>Precio compra</th>
                        <th>Precio venta</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="align-middle text-center">
                        <form id="form-productos" action="" novalidate>
                            <td style="width: 150px" class="text-center">
                                <input type="number" class="form-control" name="cantidad" id="cantidad" required>
                            </td>
                            <td class="text-center">
                                <input type="text" class="form-control" name="productos" id="productos" required>
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control" name="precio_compra" id="precio_compra"
                                    step="0.01" required>
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control" name="precio_venta" id="precio_venta"
                                    step="0.01" required>
                            </td>
                            <td>
                                <input type="hidden" value="{{ $nota->id }}" name="id_nota" id="id_nota">
                                <button type="button" class="btn btn-success w-100" id="agregar_producto">Agregar</button>
                            </td>
                        </form>
                    </tr>
                    @foreach ($productos as $item)
                        <tr class="align-middle text-center" id="row-{{ $item->id }}">
                            <td class="text-center">
                                <input type="number" class="form-control cantidad" value="{{ $item->cantidad }}" required>
                            </td>
                            <td class="text-center">
                                <input type="text" class="form-control producto" value="{{ $item->producto }}" required>
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control precio_compra" value="{{ $item->precio_compra }}"
                                    step="0.01" required>
                            </td>
                            <td class="text-center">
                                <input type="number" class="form-control precio_venta" value="{{ $item->precio_venta }}"
                                    step="0.01" required>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary btn-editar w-100"
                                    data-id="{{ $item->id }}">Editar</button>
                                <form id="form-eliminar_prodcutos" action="" novalidate>
                                    <input type="hidden" value="{{ $item->id }}" name="id_producto"
                                        id="id_producto">
                                    <button type="button" class="btn btn-warning mt-2 btn-eliminar w-100"
                                        data-id="{{ $item->id }}">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>
        <hr>
        <h4>Abonos</h4>
        <div class="table-responsive" style="border-radius: 5px">
            <table class="table table-hover">
                <thead>
                    <tr class="align-middle text-center">
                        <th>Dinero</th>
                        <th>Fecha</th>
                        <th>Opciones</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="align-middle text-center">
                        <form id="form-productos" action="" novalidate>
                            <td class="text-center">
                                <input type="number" class="form-control" name="abono" id="abono" required>
                            </td>
                            <td class="text-center">
                                <input type="text" class="form-control" name="fecha" id="fecha" required>
                            </td>
                            <td>
                                <input type="hidden" value="{{ $nota->id }}" name="id_nota" id="id_nota">
                                <button type="button" class="btn btn-success w-100" id="agregar_abono">Agregar</button>
                            </td>
                        </form>
                    </tr>
                    @foreach ($abonos as $item)
                        <tr class="align-middle text-center" id="row-{{ $item->id }}">
                            <td class="text-center">
                                <input type="number" class="form-control abono" value="{{ $item->abono }}" required>
                            </td>
                            <td class="text-center">
                                <input type="date" class="form-control fecha" value="{{ $item->fecha }}" required>
                            </td>
                            <td>
                                <button type="button" class="btn btn-primary btn-editar-abono w-100"
                                    data-id="{{ $item->id }}">Editar</button>
                                <form id="form-eliminar_abono" action="" novalidate>
                                    <input type="hidden" value="{{ $item->id }}" name="id_abono" id="id_abono">
                                    <button type="button" class="btn btn-warning mt-2 btn-eliminar-abono w-100"
                                        data-id="{{ $item->id }}">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>



        <form hidden id="form-editar-nota" action="/editar_nota" method="post">
            @csrf
            <input type="hidden" value="{{ $nota->id }}" id="id_nota" name="id_nota">
            <button type="submit" class="btn btn-primary">Editar nota</button>
        </form>

        <a href="/apartados" class="btn btn-primary fixed-button">Regresar</a>

    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $('#editar_datos_cliente').on('click', function() {
            let formData = {
                _token: $('input[name="_token"]').val(),
                id_nota: $('#id_nota').val(),
                tienda: $('#tienda').val(),
                nombre_cliente: $('#nombre_cliente').val(),
                telefono_cliente: $('#telefono_cliente').val()
            };

            // Envío de datos por AJAX
            $.ajax({
                url: '/editar_datos_cliente_nota',
                method: 'POST',
                data: formData,
                success: function(response) {
                    Swal.fire({
                        title: 'Guardado exitosamente',
                        icon: 'success',
                        timer: 1500, // Cerrar después de 1.5 segundos
                        showConfirmButton: false
                    }).then(() => {
                        $('#form-editar-nota').submit(); // Recargar la página
                    });
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 422) {
                        // Extraer y mostrar los errores de validación
                        let errors = xhr.responseJSON.errors;
                        let errorMessages = '';

                        // Concatenar los errores con salto de línea
                        $.each(errors, function(key, value) {
                            errorMessages += value +
                                '\n'; // Cada error en una nueva línea
                        });

                        // Mostrar los mensajes de error en SweetAlert
                        Swal.fire({
                            title: 'Errores de validación',
                            html: errorMessages.replace(/\n/g,
                                '<br>'
                            ), // Reemplazar los saltos de línea por <br> para HTML
                            icon: 'error'
                        });
                    } else {
                        // Manejar otros errores no relacionados con la validación
                        Swal.fire({
                            title: 'Ocurrió un error',
                            text: xhr.responseText,
                            icon: 'error'
                        });
                    }
                }
            });
        });

        $('#agregar_producto').on('click', function() {
            let formData = {
                _token: $('input[name="_token"]').val(),
                id_nota: $('#id_nota').val(),
                cantidad: $('#cantidad').val(),
                productos: $('#productos').val(),
                precio_compra: $('#precio_compra').val(),
                precio_venta: $('#precio_venta').val()
            };

            // Envío de datos por AJAX
            $.ajax({
                url: '/agregar_producto_nota',
                method: 'POST',
                data: formData,
                success: function(response) {
                    Swal.fire({
                        title: 'Guardado exitosamente',
                        icon: 'success',
                        timer: 1500, // Cerrar después de 1.5 segundos
                        showConfirmButton: false
                    }).then(() => {
                        $('#form-editar-nota').submit(); // Recargar la página
                    });
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 422) {
                        // Extraer y mostrar los errores de validación
                        let errors = xhr.responseJSON.errors;
                        let errorMessages = '';

                        // Concatenar los errores con salto de línea
                        $.each(errors, function(key, value) {
                            errorMessages += value +
                                '\n'; // Cada error en una nueva línea
                        });

                        // Mostrar los mensajes de error en SweetAlert
                        Swal.fire({
                            title: 'Errores de validación',
                            html: errorMessages.replace(/\n/g,
                                '<br>'
                            ), // Reemplazar los saltos de línea por <br> para HTML
                            icon: 'error'
                        });
                    } else {
                        // Manejar otros errores no relacionados con la validación
                        Swal.fire({
                            title: 'Ocurrió un error',
                            text: xhr.responseText,
                            icon: 'error'
                        });
                    }
                }
            });
        });

        $('#agregar_abono').on('click', function() {
            let formData = {
                _token: $('input[name="_token"]').val(),
                id_nota: $('#id_nota').val(),
                abono: $('#abono').val(),
                fecha: $('#fecha').val()
            };

            // Envío de datos por AJAX
            $.ajax({
                url: '/agregar_abono_nota',
                method: 'POST',
                data: formData,
                success: function(response) {
                    Swal.fire({
                        title: 'Guardado exitosamente',
                        icon: 'success',
                        timer: 1500, // Cerrar después de 1.5 segundos
                        showConfirmButton: false
                    }).then(() => {
                        $('#form-editar-nota').submit(); // Recargar la página
                    });
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 422) {
                        // Extraer y mostrar los errores de validación
                        let errors = xhr.responseJSON.errors;
                        let errorMessages = '';

                        // Concatenar los errores con salto de línea
                        $.each(errors, function(key, value) {
                            errorMessages += value +
                                '\n'; // Cada error en una nueva línea
                        });

                        // Mostrar los mensajes de error en SweetAlert
                        Swal.fire({
                            title: 'Errores de validación',
                            html: errorMessages.replace(/\n/g,
                                '<br>'
                            ), // Reemplazar los saltos de línea por <br> para HTML
                            icon: 'error'
                        });
                    } else {
                        // Manejar otros errores no relacionados con la validación
                        Swal.fire({
                            title: 'Ocurrió un error',
                            text: xhr.responseText,
                            icon: 'error'
                        });
                    }
                }
            });
        });

        $(document).on('click', '.btn-eliminar', function(e) {
            e.preventDefault();

            let id = $(this).data('id'); // Obtener el ID del producto
            let row = $(this).closest('tr'); // Obtener la fila actual

            let formData = {
                _token: $('input[name="_token"]').val(),
                id_producto: id
            };

            console.log(formData);
            $.ajax({
                url: '/eliminar_producto_nota',
                method: 'POST',
                data: formData,
                success: function(response) {
                    Swal.fire({
                        title: 'Guardado exitosamente',
                        icon: 'success',
                        timer: 1500, // Cerrar después de 1.5 segundos
                        showConfirmButton: false
                    }).then(() => {
                        $('#form-editar-nota').submit(); // Recargar la página
                    });
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 422) {
                        // Extraer y mostrar los errores de validación
                        let errors = xhr.responseJSON.errors;
                        let errorMessages = '';

                        // Concatenar los errores con salto de línea
                        $.each(errors, function(key, value) {
                            errorMessages += value +
                                '\n'; // Cada error en una nueva línea
                        });

                        // Mostrar los mensajes de error en SweetAlert
                        Swal.fire({
                            title: 'Errores de validación',
                            html: errorMessages.replace(/\n/g,
                                '<br>'
                            ), // Reemplazar los saltos de línea por <br> para HTML
                            icon: 'error'
                        });
                    } else {
                        // Manejar otros errores no relacionados con la validación
                        Swal.fire({
                            title: 'Ocurrió un error',
                            text: xhr.responseText,
                            icon: 'error'
                        });
                    }
                }
            });
        });

        $(document).on('click', '.btn-eliminar-abono', function(e) {
            e.preventDefault();

            let id = $(this).data('id'); // Obtener el ID del producto
            let row = $(this).closest('tr'); // Obtener la fila actual

            let formData = {
                _token: $('input[name="_token"]').val(),
                id_abono: id
            };

            console.log(formData);
            $.ajax({
                url: '/eliminar_abono_nota',
                method: 'POST',
                data: formData,
                success: function(response) {
                    Swal.fire({
                        title: 'Guardado exitosamente',
                        icon: 'success',
                        timer: 1500, // Cerrar después de 1.5 segundos
                        showConfirmButton: false
                    }).then(() => {
                        $('#form-editar-nota').submit(); // Recargar la página
                    });
                },
                error: function(xhr, status, error) {
                    if (xhr.status === 422) {
                        // Extraer y mostrar los errores de validación
                        let errors = xhr.responseJSON.errors;
                        let errorMessages = '';

                        // Concatenar los errores con salto de línea
                        $.each(errors, function(key, value) {
                            errorMessages += value +
                                '\n'; // Cada error en una nueva línea
                        });

                        // Mostrar los mensajes de error en SweetAlert
                        Swal.fire({
                            title: 'Errores de validación',
                            html: errorMessages.replace(/\n/g,
                                '<br>'
                            ), // Reemplazar los saltos de línea por <br> para HTML
                            icon: 'error'
                        });
                    } else {
                        // Manejar otros errores no relacionados con la validación
                        Swal.fire({
                            title: 'Ocurrió un error',
                            text: xhr.responseText,
                            icon: 'error'
                        });
                    }
                }
            });
        });

        $(document).on('click', '.btn-editar', function(e) {
            e.preventDefault();

            let id = $(this).data('id'); // Obtener el ID del producto
            let row = $(this).closest('tr'); // Obtener la fila actual

            // Extraer los valores de los campos de la fila
            let formData = {
                _token: $('input[name="_token"]').val(),
                id_producto: id,
                cantidad: row.find('.cantidad').val(),
                producto: row.find('.producto').val(),
                precio_compra: row.find('.precio_compra').val(),
                precio_venta: row.find('.precio_venta').val()
            };

            // Enviar la solicitud AJAX para actualizar el producto
            $.ajax({
                url: `/editar_producto_nota`, // Ruta para actualizar el producto
                method: 'POST',
                data: formData,
                success: function(response) {
                    Swal.fire({
                        title: 'Actualizado exitosamente',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        $('#form-editar-nota').submit();
                    });
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        // Extraer y mostrar los errores de validación
                        let errors = xhr.responseJSON.errors;
                        let errorMessages = '';

                        $.each(errors, function(key, value) {
                            errorMessages += value + '\n';
                        });

                        Swal.fire({
                            title: 'Errores de validación',
                            html: errorMessages.replace(/\n/g, '<br>'),
                            icon: 'error'
                        });
                    } else {
                        Swal.fire({
                            title: 'Ocurrió un error',
                            text: xhr.responseText,
                            icon: 'error'
                        });
                    }
                }
            });
        });

        $(document).on('click', '.btn-editar-abono', function(e) {
            e.preventDefault();

            let id = $(this).data('id'); // Obtener el ID del producto
            let row = $(this).closest('tr'); // Obtener la fila actual

            // Extraer los valores de los campos de la fila
            let formData = {
                _token: $('input[name="_token"]').val(),
                id_abono: id,
                abono: row.find('.abono').val(),
                fecha: row.find('.fecha').val(),
            };

            // Enviar la solicitud AJAX para actualizar el producto
            $.ajax({
                url: `/editar_abono_nota`, // Ruta para actualizar el producto
                method: 'POST',
                data: formData,
                success: function(response) {
                    Swal.fire({
                        title: 'Actualizado exitosamente',
                        icon: 'success',
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        $('#form-editar-nota').submit();
                    });
                },
                error: function(xhr) {
                    if (xhr.status === 422) {
                        // Extraer y mostrar los errores de validación
                        let errors = xhr.responseJSON.errors;
                        let errorMessages = '';

                        $.each(errors, function(key, value) {
                            errorMessages += value + '\n';
                        });

                        Swal.fire({
                            title: 'Errores de validación',
                            html: errorMessages.replace(/\n/g, '<br>'),
                            icon: 'error'
                        });
                    } else {
                        Swal.fire({
                            title: 'Ocurrió un error',
                            text: xhr.responseText,
                            icon: 'error'
                        });
                    }
                }
            });
        });
    </script>


    <script>
        // Obtiene la fecha de hoy en el formato YYYY-MM-DD
        const today = new Date().toISOString().split('T')[0];

        // Establece el valor del input con la fecha de hoy
        document.getElementById('fecha').value = today;
    </script>
@endsection
