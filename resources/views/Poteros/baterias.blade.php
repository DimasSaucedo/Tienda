@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.css">
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
                    <thead style="background: #e9183b; color: white">
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
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Bateria</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="needs-validation" novalidate id="agregarBateriaForm" action="/agregarBateria" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="col-md-12">
                            <label class="form-label">Ingresa el No. Bateria: </label>
                            <input class="form-control" name="nobateria" id="nobateria" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Ingresa la marca: </label>
                            <select class="form-select" name="marca" id="marca" required>
                                <option value="" disabled selected>Seleccione una opción</option>
                                @foreach ($cat_marcas as $item)
                                    <option value="{{ $item->nombre }}">{{ $item->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Ingresa la cantidad: </label>
                            <input class="form-control" type="number" id="cantidad" name="cantidad" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Ingresa el precio de compra: </label>
                            <input class="form-control" type="number" id="precioCompra" name="precioCompra" step="0.01"
                                required>
                        </div>
                        <div class="col-md-12" style="display: none" id="precioVentaContainer">
                            <label class="form-label">Ingresa el precio de venta: </label>
                            <input class="form-control" type="number" id="precioVenta" name="precioVenta" step="0.01">
                        </div>
                    </div>
                    <div class="modal-footer">
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
                <div class="modal-header">
                    <h3 class="modal-title fs-5">Actualizar Batería: <span id="modal-titulo"></span></h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="needs-validation" novalidate id="actualizarBateriaForm" action="/actualizar_bateria_p"
                    method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="modal-id">
                        <div class="col-md-12">
                            <label class="form-label">No. Batería:</label>
                            <input class="form-control" name="nobateria" id="modal-nobateria" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Marca:</label>
                            <select class="form-select" name="marca" id="modal-marca">
                                <option value="" disabled selected>Seleccionar una opción</option>
                                @foreach ($cat_marcas as $item)
                                    <option value="{{ $item->nombre }}">{{ $item->nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Cantidad:</label>
                            <input class="form-control" type="number" id="modal-cantidad" name="cantidad">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Precio de Compra:</label>
                            <input class="form-control" type="number" id="modal-precioCompra" name="precioCompra"
                                step="0.01" required>
                        </div>
                        <div class="col-md-12" style="display: none" id="modal-precioVentaContainer">
                            <label class="form-label">Precio de Venta:</label>
                            <input class="form-control" type="number" id="modal-precioVenta" name="precioVenta" step="0.01">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                        <button type="submit" class="btn btn-primary">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.dataTables.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">

    <script>
        // Función para abrir el modal de actualización y llenar los campos
        function abrirModalActualizar(id, noBateria, marca, cantidad, precioCompra, precioVenta) {
            document.getElementById('modal-id').value = id;
            document.getElementById('modal-nobateria').value = noBateria;
            document.getElementById('modal-marca').value = marca;
            document.getElementById('modal-cantidad').value = cantidad;
            document.getElementById('modal-precioCompra').value = precioCompra;
            document.getElementById('modal-precioVenta').value = precioVenta;

            // Mostrar el campo de precio de venta si la marca es "POWER-CONECTION"
            if (marca === "POWER-CONECTION") {
                document.getElementById('modal-precioVentaContainer').style.display = 'block';
                document.getElementById('modal-precioVenta').setAttribute('required', true);
            } else {
                document.getElementById('modal-precioVentaContainer').style.display = 'none';
                document.getElementById('modal-precioVenta').removeAttribute('required');
            }

            // Abrir el modal
            var modal = new bootstrap.Modal(document.getElementById('modal-actualizar'));
            modal.show();
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
                paging: false,
                ordering: false
            });
        });
    </script>
@endsection