@extends('layouts.app')
@section('content')

<div class="container mt-5">
    <a href="/agregar_apartado" class="btn btn-primary mb-5">Nueva nota</a>
    <div class="row row-cols-1 row-cols-md-3 g-4">
        @foreach ($notas as $row)
        @php
        $notas_detalle = notas_detalle($row->id);
        @endphp
        <div class="col">
            <div class="card h-100">
                <div class="card-body">
                    @if ($row->estado == 0)
                    <span class="badge rounded-pill text-bg-success" style="font-size:14px">Pagada</span>
                    @else
                    <span class="badge rounded-pill text-bg-warning" style="font-size:14px">Pendiente</span>
                    @endif
                    <h5 class="card-title" style="float: right">Fecha: {{ $row->fecha }}</h5>
                    <br><br>
                    <p class="card-text"><strong>Nombre del cliente: </strong>{{ $row->nombre_cliente }}</p>
                    <p class="card-text" for=""><strong>Telefono del cliente:
                        </strong>{{ $row->telefono_cliente }}</p>
                    <p class="card-text" for=""><strong>Tienda: </strong>{{ $row->tienda }}</p>
                    <hr>
                    <h5>Productos</h5>
                    <div class="container">
                        <div class="table-responsive">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <th class="text-center">Can.</th>
                                        <th style="width: 100px">Prod.</th>
                                        <th class="text-center">Precio Venta</th>
                                        <th class="text-center">Precio Compra</th>
                                    </thead>
                                    <tbody>
                                        @foreach ($apartados as $item)
                                        @if ($item->id_nota == $row->id)
                                        <tr>
                                            <td class="text-center">{{ $item->cantidad }}</td>
                                            <td style="width: 100px">{{ $item->producto }}</td>
                                            <td class="text-center">{{ formatearNumero($item->precio_compra) }}</td>
                                            <td class="text-center">{{ formatearNumero($item->precio_venta) }}</td>
                                        </tr>
                                        @endif
                                        @endforeach
                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td class="text-center">{{formatearNumero($notas_detalle->total_compra)}}
                                            </td>
                                            <td class="text-center">{{formatearNumero($notas_detalle->total_venta)}}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>

                    <hr>
                    <h5>Abonos</h5>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <th class="text-center">Dinero</th>
                                <th class="text-center">Fecha</th>
                            </thead>
                            <tbody>
                                @foreach ($abonos as $ab)
                                @if ($ab->id_nota == $row->id)
                                <tr>
                                    <td class="text-center">{{ formatearNumero($ab->abono) }}</td>
                                    <td class="text-center">{{ $ab->fecha }}</td>

                                </tr>
                                @endif
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <hr>
                    <h5>Resumen</h5>
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead>
                                <th class="text-center">Total de la compra</th>
                                <th class="text-center">Abonos</th>
                                <th class="text-center">Saldo restante</th>
                            </thead>
                            <tbody>

                                <tr>
                                    <td class="text-center">{{formatearNumero($notas_detalle->total_venta)}}</td>
                                    <td class="text-center">{{formatearNumero($notas_detalle->total_abonos)}}</td>
                                    <td class="text-center">{{formatearNumero($notas_detalle->total_restante)}}</td>
                                </tr>

                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="card-footer row">
                    <div class="col-sm-4 text-center">
                        <form action="/editar_nota" method="post">
                            @csrf
                            <input type="hidden" value="{{$row->id}}" id="id_nota" name="id_nota">
                            <button type="submit" class="btn btn-primary">Editar nota</button>
                        </form>
                    </div>
                    <div class="col-sm-4 text-center">
                        @if($row->estado == 1)
                        <form action="/saldar_nota" method="POST">
                            @csrf
                            <input type="hidden" value="{{$row->id}}" id="id_nota" name="id_nota">
                            <button class="btn btn-warning ">Saldar deuda</button>
                        </form>
                        @endif
                    </div>
                    <div class="col-sm-4 text-center">
                        @if ($row->estado == 0)
                        <form action="/eliminar_nota" method="POST">
                            @csrf
                            <input type="hidden" value="{{$row->id}}" id="id_nota" name="id_nota">
                            <button class="btn btn-danger ">Eliminar nota</button>
                        </form>
                        @endif
                    </div>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    <br><br>
</div>
@endsection