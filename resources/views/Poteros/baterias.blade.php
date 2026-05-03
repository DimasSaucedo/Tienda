@extends('layouts.app')
@section('content')
    {{--
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.css"> --}}
    <div class="container mt-4">
        <h2 class="mb-4">Baterias de Potreros</h2>

        <div class="table-responsive">
            <div class="row align-items-center">
                <div class="col-md-3">
                    <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-agregar">
                        Agregar nueva bateria
                    </button>
                </div>

                <div class="col-md-6 ms-auto">
                    <form action="/cargar_datos_baterias" method="POST" enctype="multipart/form-data"
                        class="d-flex gap-2 justify-content-end">
                        @csrf
                        <input type="hidden" name="origen" value="Potreros">
                        <input type="file" name="archivo" class="form-control w-auto">
                        <button type="submit" class="btn btn-info" id="btn-cargar">Cargar</button>
                    </form>
                </div>
            </div>
            <br>

            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 10px">Cantidad</th>
                            <th class="text-center" style="width: 10px">No. Bateria</th>
                            <th class="text-center">Marca</th>
                            <th class="text-center" style="width: 50px">Clasificación</th>
                            <th class="text-center" style="width: 100px">Precio Compra</th>
                            <th class="text-center" style="width: 100px">Precio Venta</th>
                            <th class="text-center">Opciones</th>
                        </tr>
                    </thead>
                    <tbody style="background: white">
                        @foreach ($baterias as $ll)
                            <tr class="{{ $ll->Cantidad == 0 ? 'table-warning' : '' }}">
                                <td class="text-center" style="width: 10px">{{ $ll->Cantidad }}</td>
                                <td class="text-center" style="width: 150px">
                                    <a href="#"
                                        onclick="abrirDetalle({{ $ll->id }}, 
                                        '{{ $ll->NoBateria }}', '{{ $ll->Marca }}',
                                        {{ $ll->ca_frio ?? 0 }}, {{ $ll->cca_caliente ?? 0 }},
                                        {{ $ll->capacidad_reserva ?? 0 }},
                                        {{ $ll->largo ?? 0 }}, {{ $ll->ancho ?? 0 }}, {{ $ll->alto ?? 0 }},
                                        {{ $ll->peso_humedo ?? 0 }},
                                        '{{ $ll->polaridad_izq }}', '{{ $ll->polaridad_der }}',
                                        {{ $ll->precio_con_acumulador ?? 0 }}, 
                                        {{ $ll->PrecioCompra ?? 0 }},
                                        {{ $ll->PrecioVenta ?? 0 }},
                                        {{ $ll->PrecioVentaSinAcumulador ?? 0 }},
                                        {{ $ll->clasificacion_acumulador }})">
                                        {{ $ll->NoBateria }}
                                    </a>
                                </td>
                                <td class="text-center" style="width: 150px">{{ $ll->Marca }}</td>
                                <td class="text-center">
                                    <span class="badge rounded-pill text-white fw-bold"
                                        style="background:#e9183b; font-size: 0.9rem;">
                                        {{ $ll->clasificacion_acumulador ?? '-' }}
                                    </span>
                                </td>
                                <td class="text-center" style="width: 80px">{{ formatearNumero($ll->PrecioCompra) }}</td>
                                <td class="text-center" style="width: 80px">{{ formatearNumero($ll->PrecioVenta) }}</td>
                                <td class="text-center" style="width: 100px">
                                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-primary dropdown-toggle"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-solid fa-gear"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="#"
                                                        onclick="abrirModalActualizar({{ $ll->id }}, '{{ $ll->NoBateria }}', '{{ $ll->Marca }}', {{ $ll->Cantidad }}, {{ $ll->PrecioCompra }}, {{ $ll->PrecioVenta }})">Actualizar</a>
                                                </li>
                                                <li>
                                                    @if ($ll->Cantidad > 0)
                                                        <form action="/vender_producto" method="POST">
                                                            @csrf
                                                            <input hidden value="{{ $ll->id }}" name="id"
                                                                id="id">
                                                            <input hidden value="BateriasPotreros" name="producto"
                                                                id="producto">
                                                            <button type="submit" class="dropdown-item"
                                                                style="width: 100px">Vender</button>
                                                        </form>
                                                    @endif
                                                </li>
                                                <li>
                                                    <form action="/eliminar_bateriap" method="POST">
                                                        @csrf
                                                        <input hidden value="{{ $ll->id }}" name="id"
                                                            id="id">
                                                        <input type="hidden" value="potreros" id="tienda"
                                                            name="tienda">
                                                        <button type="submit" class="dropdown-item"
                                                            style="width: 100px">Eliminar</button>
                                                    </form>
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
        </div>
    </div>

    <div class="modal fade" id="modal-agregar">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background: #e9183b; color: white">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Bateria</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="needs-validation" novalidate id="agregarBateriaForm" action="/agregarBateria"
                    method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="col-md-12 form-floating mb-3">
                            <input class="form-control" name="nobateria" id="nobateria" placeholder=" " required>
                            <label for="nobateria">Ingresa el No. Bateria: </label>
                        </div>
                        <div class="col-md-12 form-floating mb-3">
                            <select class="form-select" name="marca" id="marca" required>
                                <option value="" disabled selected>Seleccione una opción</option>
                                @foreach ($cat_marcas as $item)
                                    <option value="{{ $item->nombre }}">{{ $item->nombre }}</option>
                                @endforeach
                            </select>
                            <label for="marca">Ingresa la marca: </label>
                        </div>
                        <div class="col-md-12 form-floating mb-3">
                            <input class="form-control" type="number" id="cantidad" name="cantidad" placeholder=" ">
                            <label for="cantidad">Ingresa la cantidad: </label>
                        </div>
                        <div class="col-md-12 form-floating mb-3">
                            <input class="form-control" type="number" id="precioCompra" name="precioCompra"
                                step="0.01" placeholder=" " required>
                            <label for="precioCompra">Ingresa el precio de compra: </label>
                        </div>
                        <div class="col-md-12 form-floating mb-3" style="display: none" id="precioVentaContainer">
                            <input class="form-control" type="number" id="precioVenta" name="precioVenta"
                                step="0.01" placeholder=" ">
                            <label for="precioVenta">Ingresa el precio de venta: </label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" value="potreros" name="tienda" id="tienda" required>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary" form="agregarBateriaForm">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal para actualizar batería -->
    <div class="modal fade" id="modal-actualizar" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header" style="background: #e9183b; color: white">
                    <h3 class="modal-title fs-5">Actualizar Batería: <span id="modal-titulo"></span></h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="needs-validation" novalidate id="actualizarBateriaForm" action="/actualizarBateria"
                    method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="modal-id">
                        <div class="col-md-12 form-floating mb-3">
                            <input class="form-control" name="nobateria" id="modal-nobateria" placeholder=" " required>
                            <label for="nobateria">No. Batería:</label>
                        </div>
                        <div class="col-md-12 form-floating mb-3">
                            <select class="form-select" name="marca" id="modal-marca">
                                <option value="" disabled selected>Seleccionar una opción</option>
                                @foreach ($cat_marcas as $item)
                                    <option value="{{ $item->nombre }}">{{ $item->nombre }}</option>
                                @endforeach
                            </select>
                            <label for="marca">Marca:</label>
                        </div>
                        <div class="col-md-12 form-floating mb-3">
                            <input class="form-control" type="number" id="modal-cantidad" name="cantidad"
                                placeholder=" ">
                            <label for="cantidad">Cantidad:</label>
                        </div>
                        <div class="col-md-12 form-floating mb-3">
                            <input class="form-control" type="number" id="modal-precioCompra" name="precioCompra"
                                step="0.01" placeholder=" " required>
                            <label for="precioCompra">Precio de Compra:</label>
                        </div>
                        <div class="col-md-12 form-floating mb-3" id="modal-precioVentaContainer">
                            <input class="form-control" type="number" id="modal-precioVenta" name="precioVenta"
                                step="0.01" placeholder=" ">
                            <label for="precioVenta">Precio de Venta:</label>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" value="potreros" id="tienda" name="tienda">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="modal fade" id="modal-detalle" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: #e9183b; color: white">
                    <h5 class="modal-title">Detalle: <span id="detalle-titulo"></span></h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Columna izquierda: datos técnicos -->
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">Datos Técnicos</h6>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td class="fw-bold">CA (0°C):</td>
                                    <td id="detalle-ca"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">CCA (-18°C):</td>
                                    <td id="detalle-cca"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Capacidad Reserva:</td>
                                    <td id="detalle-reserva"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Dimensiones:</td>
                                    <td id="detalle-dimensiones"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Peso húmedo:</td>
                                    <td id="detalle-peso"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Polaridad:</td>
                                    <td id="detalle-polaridad"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Clasificación:</td>
                                    <td>
                                        <span id="detalle-clasificacion" class="badge rounded-pill text-white fw-bold"
                                            style="background:#e9183b; font-size:0.95rem;">
                                        </span>
                                    </td>
                                </tr>
                            </table>
                        </div>
                        <!-- Columna derecha: precios -->
                        <div class="col-md-6">
                            <h6 class="text-muted mb-3">Precios</h6>
                            <table class="table table-sm table-borderless">
                                <tr>
                                    <td class="fw-bold">Precio de lista:</td>
                                    <td id="detalle-precio-lista"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Precio final compra:</td>
                                    <td id="detalle-precio-compra"></td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <hr class="my-1">
                                    </td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Venta con acumulador:</td>
                                    <td id="detalle-venta-con"></td>
                                </tr>
                                <tr>
                                    <td class="fw-bold">Venta sin acumulador:</td>
                                    <td id="detalle-venta-sin"></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    {{--
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.dataTables.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css"> --}}

    <script>
        // Función para abrir el modal de actualización y llenar los campos
        function abrirModalActualizar(id, noBateria, marca, cantidad, precioCompra, precioVenta) {
            document.getElementById('modal-id').value = id;
            document.getElementById('modal-nobateria').value = noBateria;
            document.getElementById('modal-marca').value = marca;
            document.getElementById('modal-cantidad').value = cantidad;
            document.getElementById('modal-precioCompra').value = precioCompra;
            document.getElementById('modal-precioVenta').value = precioVenta;

            // Mostrar y habilitar/deshabilitar el campo precioVenta según la marca
            togglePrecioVenta(marca);

            // Agregar el listener para detectar cambios en la marca
            document.getElementById('modal-marca').addEventListener('change', function() {
                togglePrecioVenta(this.value);
            });

            // Abrir el modal
            var modal = new bootstrap.Modal(document.getElementById('modal-actualizar'));
            modal.show();
        }

        function togglePrecioVenta(marca) {
            const precioVentaField = document.getElementById('modal-precioVenta');

            if (marca === "POWER-CONECTION" || marca === "OTRA") {
                precioVentaField.readOnly = false; // Habilita el campo
            } else {
                precioVentaField.readOnly = true; // Deshabilita el campo
            }
        }

        // Limpiar el modal al cerrarse
        document.getElementById('modal-actualizar').addEventListener('hidden.bs.modal', function() {
            document.getElementById('actualizarBateriaForm').reset();
        });

        // Lógica para mostrar/ocultar el campo de precio de venta en el modal de agregar
        $(document).on('change', '#marca', function() {
            if ($(this).val() === "POWER-CONECTION" || $(this).val() === "OTRA") {
                $('#precioVentaContainer').css('display', 'block');
                $('#precioVenta').attr('required', true); // Agregar required
            } else {
                $('#precioVentaContainer').css('display', 'none');
                $('#precioVenta').removeAttr('required'); // Quitar required
            }
        });

        // Configuración de DataTables
        $(document).ready(function() {
            $('#example').DataTable({
                responsive: true,
                dom: 'Blfrtip',
                stateSave: false,
                language: {
                    "url": "/assets/lib/datatable/es.json"
                },
                buttons: [

                ],
                paging: false,
                ordering: false
            });
        });

        // Confirmación para ELIMINAR
        document.querySelectorAll('form[action="/eliminar_bateriap"]').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const formRef = this;
                Swal.fire({
                    title: '¿Eliminar batería?',
                    text: 'Esta acción no se puede deshacer.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then(result => {
                    if (result.isConfirmed) formRef.submit();
                });
            });
        });

        // Confirmación para VENDER
        document.querySelectorAll('form[action="/vender_producto"]').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const formRef = this;
                Swal.fire({
                    title: '¿Confirmar venta?',
                    text: '¿Deseas registrar la venta de esta batería?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#198754',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Sí, vender',
                    cancelButtonText: 'Cancelar'
                }).then(result => {
                    if (result.isConfirmed) formRef.submit();
                });
            });
        });

        // Alertas de sesión (success/error desde el controlador)
        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: '¡Éxito!',
                text: '{{ session('success') }}',
                timer: 3000,
                showConfirmButton: false,
                toast: true,
                position: 'top-end'
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: '{{ session('error') }}',
                confirmButtonColor: '#d33'
            });
        @endif

        function abrirDetalle(id, noBateria, marca, ca, cca, reserva, largo, ancho, alto,
            peso, polIzq, polDer, precioLista, precioCompra, ventaCon, ventaSin, clasificacion) {

            const fmt = val => '$' + parseFloat(val).toLocaleString('es-MX', {
                minimumFractionDigits: 2
            });

            document.getElementById('detalle-titulo').textContent = noBateria + ' - ' + marca;
            document.getElementById('detalle-ca').textContent = ca + ' Amp';
            document.getElementById('detalle-cca').textContent = cca + ' Amp';
            document.getElementById('detalle-reserva').textContent = reserva + ' min';
            document.getElementById('detalle-dimensiones').textContent = largo + ' x ' + ancho + ' x ' + alto + ' mm';
            document.getElementById('detalle-peso').textContent = peso + ' kg';
            document.getElementById('detalle-polaridad').textContent = '(' + polIzq + ') / (' + polDer + ')';
            document.getElementById('detalle-clasificacion').textContent = clasificacion;
            document.getElementById('detalle-precio-lista').textContent = fmt(precioLista);
            document.getElementById('detalle-precio-compra').textContent = fmt(precioCompra);
            document.getElementById('detalle-venta-con').textContent = fmt(ventaCon);
            document.getElementById('detalle-venta-sin').textContent = fmt(ventaSin);

            new bootstrap.Modal(document.getElementById('modal-detalle')).show();
        }

        document.querySelector('form[action="/cargar_datos_baterias"]').addEventListener('submit', function() {
            const btn = document.getElementById('btn-cargar');
            btn.disabled = true;
            btn.innerHTML = '<span class="spinner-border spinner-border-sm"></span> Procesando...';
        });
    </script>
@endsection
