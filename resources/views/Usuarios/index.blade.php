@extends('layouts.app')
@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.css">
    <div class="container mt-4">
        <h2 class="mb-4">Usuarios</h2>

        <div class="table-responsive">
            <div>
                <button type="button" class="btn btn-success" data-bs-toggle="modal" data-bs-target="#modal-agregar">Agregar
                    usuario</button>
            </div>
            <br>
            <table id="example" class="table table-striped table-bordered table-hover" style="width:95%">
                <thead style="background: #e9183b !important; color: white">
                    <tr>
                        <th class="text-center">ID</th>
                        <th>NOMBRE</th>
                        <th>EMAIL</th>
                        <th class="text-center">ESTADO</th>
                        <th class="text-center">OPCIONES</th>
                    </tr>
                </thead>
                <tbody style="background: white">
                    @foreach ($usuarios as $row)
                        <tr>
                            <td class="text-center">{{ $row->id }}</td>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->email }}</td>
                            @if ($row->estado == 0)
                                <td class="align-middle text-center">
                                    <span class="badge text-bg-secondary">
                                        Inactiva
                                        <span class="ms-1 fas fa-ban" data-fa-transform="shrink-2"></span>
                                    </span>
                                </td>
                            @else
                                <td class="9 align-middle text-center">
                                    <span class="badge text-bg-success ">
                                        Activa
                                        <span class="ms-1 fas fa-check" data-fa-transform="shrink-2"></span>
                                    </span>
                                </td>
                            @endif
                            <td class="text-center">
                                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-primary dropdown-toggle"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <i class="fa-solid fa-gear"></i>
                                        </button>
                                        <ul class="dropdown-menu">
                                            <li>
                                                <form action="/editar_usuarios" method="post">
                                                    @csrf
                                                    <input hidden value="{{ $row->id }}" name="id_usuario"
                                                        id="id_usuario">
                                                    <button type="submit" class="dropdown-item">Editar</button>
                                                </form>
                                            </li>
                                            <li>
                                                @if ($row->estado == 0)
                                                    <form action="/habilitar_usuario" method="POST">
                                                        @csrf
                                                        <input hidden value="{{ $row->id }}" name="id_usuario"
                                                            id="id_usuario">
                                                        <button type="submit" class="dropdown-item">Habilitar</button>
                                                    </form>
                                                @else
                                                    <form action="/deshabilitar_usuario" method="POST">
                                                        @csrf
                                                        <input hidden value="{{ $row->id }}" name="id_usuario"
                                                            id="id_usuario">
                                                        <button type="submit" class="dropdown-item">Deshabilitar</button>
                                                    </form>
                                                @endif
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


        });
    </script>
@endsection
