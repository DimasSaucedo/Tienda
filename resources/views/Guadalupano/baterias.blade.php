@extends('layouts.app')

@section('content')
    <div class="container mt-4">
        <h2 class="mb-4"> Baterias del Guadalupano</h2>

        <div class="table-responsive">
            <div>
                <button type="button" class="btn btn-success" data-toggle="modal" data-target="#modal-agregar">Agregar nueva
                    bateria</button>
            </div>
            <br>
            <table id="example" class="table table-striped table-bordered" style="width:100%">
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
                            <td class="text-center" style="width: 10px">{{ $ll->NoBateria }}</td>
                            <td class="text-center">{{ $ll->Marca }}</td>
                            <td class="text-center" style="width: 100px">{{ $ll->PrecioCompra }}</td>
                            <td class="text-center" style="width: 100px">{{ $ll->PrecioVenta }}</td>
                            <td class="text-center">
                                <button type="button" class="btn btn-success" style="width: 100px" data-toggle="modal"
                                    data-target="#modal-actualizar-{{ $ll->id }}">Actualizar</button>
                                <br><br>
                                <form action="/eliminar_bateriag" method="POST">
                                    @csrf
                                    <input hidden value="{{ $ll->id }}" name="id" id="id">
                                    <button type="submit" class="btn btn-danger" style="width: 100px">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                        @include('Guadalupano.actualizarBateriaG')
                    @endforeach
                </tbody>
            </table>
            @include('Guadalupano.agregarBateria')
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">

    <script>
        $(document).ready(function() {
            $('#example').DataTable({
                responsive: true,
                dom: 'Blfrtip',
                stateSave: true,
                language: {
                    "url": "/assets/lib/datatable/es.json"
                },
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
