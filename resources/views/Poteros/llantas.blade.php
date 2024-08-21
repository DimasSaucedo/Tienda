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
            <table id="example" class="table table-striped table-bordered table-hover" style="width:95%">
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
                                                <a class="dropdown-item" href="#" data-bs-toggle="modal"
                                                    data-bs-target="#modal-actualizar-{{ $ll->id }}">Actualizar</a>
                                            </li>
                                            <li>
                                                @if ($ll->Cantidad > 0)
                                                    <form action="/vender_producto" method="POST">
                                                        @csrf
                                                        <input hidden value="{{ $ll->id }}" name="id"
                                                            id="id">
                                                        <input hidden value="LlantasPotreros" name="producto"
                                                            id="producto">
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
                        @include('Poteros.actualizarLlantaP')
                    @endforeach
                </tbody>
            </table>
            @include('Poteros.agregarLlanta')
        </div>
    </div>
    <br>
    <br>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.dataTables.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">

    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                responsive: true,
                dom: 'Blfrtip',
                stateSave: false,
                language: {
                    "url": "/assets/lib/datatable/es.json"
                },
                ordering: false,
                paging: false
            });

            document.getElementById('agregarLlantaForm').addEventListener('submit', function(event) {
                const fields = document.querySelectorAll('#agregarLlantaForm input[required]');
                let allFilled = true;
                fields.forEach(function(field) {
                    if (!field.value) {
                        allFilled = false;
                        field.classList.add('is-invalid');
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });

                if (!allFilled) {
                    event.preventDefault();
                    alert('Por favor, complete todos los campos.');
                }
            });

            document.getElementById('marca').addEventListener('input', function() {
                this.value = this.value.toUpperCase();
            });
            document.getElementById('letra').addEventListener('input', function() {
                this.value = this.value.toUpperCase();
            });
        });
    </script>
@endsection
