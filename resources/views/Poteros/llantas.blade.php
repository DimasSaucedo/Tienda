@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.css">
    <div class="container mt-4">
        <h2 class="mb-4">Llantas de Potreros</h2>

        <div class="table-responsive">
            <div>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-agregar">Agregar
                    nueva
                    llanta</button>
            </div>
            <br>
            <div class="table-responsive">
                <table id="example" class="table table-striped table-bordered" style="width:95%">
                    <thead style="background: #e9183b !important; color: white">
                        <tr>
                            <th class="text-center" style="width: 10px">Cantidad</th>
                            <th class="text-center" style="width: 10px">Letra</th>
                            <th class="text-center">Medida</th>
                            <th class="text-center">Marca</th>
                            <th class="text-center" style="width: 100px">Precio Compra</th>
                            <th class="text-center" style="width: 100px">Precio Venta</th>
                            <th class="text-center">Opciones</th>
                        </tr>
                    </thead>
                    <tbody style="background: white">
                        @foreach ($llantas as $ll)
                            <tr>
                                <td class="text-center" style="width: 10px">{{ $ll->Cantidad }}</td>
                                <td class="text-center" style="width: 10px">{{ $ll->Letra }}</td>
                                <td>{{ $ll->Medida }}</td>
                                <td>{{ $ll->Marca }}</td>
                                <td class="text-center" style="width: 80px">{{ formatearNumero($ll->PrecioCompra) }}</td>
                                <td class="text-center" style="width: 80px">{{ formatearNumero($ll->PrecioVenta) }}</td>
                                <td class="text-center">
                                    <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                        <div class="btn-group" role="group">
                                            <button type="button" class="btn btn-primary dropdown-toggle"
                                                data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class="fa-solid fa-gear"></i>
                                            </button>
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a class="dropdown-item" href="#"
                                                        onclick="abrirModalActualizarLlanta({{ $ll->id }}, '{{ $ll->Medida }}', '{{ $ll->Marca }}', {{ $ll->Cantidad }}, '{{ $ll->Letra }}', {{ $ll->PrecioCompra }}, {{ $ll->PrecioVenta }})">Actualizar</a>
                                                </li>
                                                <li>
                                                    @if ($ll->Cantidad > 0)
                                                        <form action="/vender_producto" method="POST">
                                                            @csrf
                                                            <input hidden value="{{ $ll->id }}" name="id" id="id">
                                                            <input hidden value="LlantasPotreros" name="producto" id="producto">
                                                            <button type="submit" class="dropdown-item"
                                                                style="width: 100px">Vender</button>
                                                        </form>
                                                    @endif
                                                </li>
                                                <li>
                                                    <form action="/eliminar_llantap" method="POST">
                                                        @csrf
                                                        <input hidden value="{{ $ll->id }}" name="id" id="id">
                                                        <button type="submit" class="dropdown-item"
                                                            style="width: 100px">Eliminar</button>
                                                    </form>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    {{-- <div class="d-flex">
                                        <button type="button" class="btn btn-success mr-2" style="width: 100px"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modal-actualizar-{{ $ll->id }}">Actualizar</button>

                                        <form action="/eliminar_llantap" method="POST">
                                            @csrf
                                            <input hidden value="{{ $ll->id }}" name="id" id="id">
                                            <button type="submit" class="btn btn-danger" style="width: 100px">Eliminar</button>
                                        </form>
                                    </div> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @include('Poteros.agregarLlanta')
        </div>
    </div>
    <br>
    <br>

    <div class="modal fade" id="modal-actualizar" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title fs-5" id="exampleModalLabel">Actualizar Llanta: <span id="modal-titulo"></span>
                    </h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form class="needs-validation" novalidate id="actualizarLlantaForm" action="/actualizar_llanta_p"
                    method="POST">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="id" id="modal-id">
                        <div class="col-md-12">
                            <label class="form-label">Medida:</label>
                            <input class="form-control" name="medida" id="modal-medida" required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Marca:</label>
                            <input class="form-control" name="marca" id="modal-marca" style="text-transform: uppercase;"
                                required>
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Cantidad:</label>
                            <input class="form-control" type="number" id="modal-cantidad" name="cantidad">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Letra:</label>
                            <input class="form-control" id="modal-letra" name="letra" style="text-transform: uppercase;">
                        </div>
                        <div class="col-md-12">
                            <label class="form-label">Precio de Compra:</label>
                            <input class="form-control" type="number" id="modal-precioCompra" name="precioCompra"
                                step="0.01" required>
                        </div>
                        <div class="col-md-12" id="modal-precioVentaContainer">
                            <label class="form-label">Precio de Venta:</label>
                            <input class="form-control" type="number" id="modal-precioVenta" name="precioVenta" step="0.01" required>
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

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.dataTables.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">

    <script>
        // Función para abrir el modal de actualización y llenar los campos
        function abrirModalActualizarLlanta(id, medida, marca, cantidad, letra, precioCompra, precioVenta) {
            document.getElementById('modal-id').value = id;
            document.getElementById('modal-medida').value = medida;
            document.getElementById('modal-marca').value = marca;
            document.getElementById('modal-cantidad').value = cantidad;
            document.getElementById('modal-letra').value = letra;
            document.getElementById('modal-precioCompra').value = precioCompra;
            document.getElementById('modal-precioVenta').value = precioVenta;


            // Abrir el modal
            var modal = new bootstrap.Modal(document.getElementById('modal-actualizar'));
            modal.show();
        }

        // Limpiar el modal al cerrarse
        document.getElementById('modal-actualizar').addEventListener('hidden.bs.modal', function () {
            document.getElementById('actualizarLlantaForm').reset();
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