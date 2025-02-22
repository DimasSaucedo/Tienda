@extends('layouts.app')
@section('content')
    {{--
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.css"> --}}
    <div class="container mt-4">
        <h2 class="mb-4">Baterias de Potreros</h2>

        <div class="table-responsive">
            <div>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-agregar">
                    Agregar nueva bateria
                </button>
            </div>
            <br>
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered table-hover" style="width:100%">
                    <thead>
                        <tr>
                            <th class="text-center" style="width: 10px">Cantidad</th>
                            <th class="text-center" style="width: 10px">No. Bateria</th>
                            <th class="text-center">Marca</th>
                            <th class="text-center" style="width: 100px">Precio Compra</th>
                            <th class="text-center" style="width: 100px">Precio Venta</th>
                            <th class="text-center">Opciones</th>
                        </tr>
                    </thead>
                    <tbody style="background: white">
                        @foreach ($baterias as $ll)
                            <tr>
                                <td class="text-center" style="width: 10px">{{ $ll->Cantidad }}</td>
                                <td class="text-center" style="width: 150px">{{ $ll->NoBateria }}</td>
                                <td class="text-center" style="width: 150px">{{ $ll->Marca }}</td>
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
                                                            <input hidden value="{{ $ll->id }}" name="id" id="id">
                                                            <input hidden value="BateriasPotreros" name="producto" id="producto">
                                                            <button type="submit" class="dropdown-item"
                                                                style="width: 100px">Vender</button>
                                                        </form>
                                                    @endif
                                                </li>
                                                <li>
                                                    <form action="/eliminar_bateriap" method="POST">
                                                        @csrf
                                                        <input hidden value="{{ $ll->id }}" name="id" id="id">
                                                        <input type="hidden" value="potreros" id="tienda" name="tienda">
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
                <form class="needs-validation" novalidate id="agregarBateriaForm" action="/agregarBateria" method="POST">
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
                            <input class="form-control" type="number" id="precioCompra" name="precioCompra" step="0.01"
                                placeholder=" " required>
                            <label for="precioCompra">Ingresa el precio de compra: </label>
                        </div>
                        <div class="col-md-12 form-floating mb-3" style="display: none" id="precioVentaContainer">
                            <input class="form-control" type="number" id="precioVenta" name="precioVenta" step="0.01"
                                placeholder=" ">
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
                            <input class="form-control" type="number" id="modal-cantidad" name="cantidad" placeholder=" ">
                            <label for="cantidad">Cantidad:</label>
                        </div>
                        <div class="col-md-12 form-floating mb-3">
                            <input class="form-control" type="number" id="modal-precioCompra" name="precioCompra"
                                step="0.01" placeholder=" " required>
                            <label for="precioCompra">Precio de Compra:</label>
                        </div>
                        <div class="col-md-12 form-floating mb-3" id="modal-precioVentaContainer">
                            <input class="form-control" type="number" id="modal-precioVenta" name="precioVenta" step="0.01"
                                placeholder=" ">
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
            document.getElementById('modal-marca').addEventListener('change', function () {
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
        document.getElementById('modal-actualizar').addEventListener('hidden.bs.modal', function () {
            document.getElementById('actualizarBateriaForm').reset();
        });

        // Lógica para mostrar/ocultar el campo de precio de venta en el modal de agregar
        $(document).on('change', '#marca', function () {
            if ($(this).val() === "POWER-CONECTION" || $(this).val() === "OTRA") {
                $('#precioVentaContainer').css('display', 'block');
                $('#precioVenta').attr('required', true); // Agregar required
            } else {
                $('#precioVentaContainer').css('display', 'none');
                $('#precioVenta').removeAttr('required'); // Quitar required
            }
        });

        // Configuración de DataTables
        $(document).ready(function () {
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
    </script>
@endsection