@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card mt-4">
            <div class="card-body">
                <form action="/editar_venta_confirmar" method="POST">
                    @csrf
                    <div class="mb-3 row">
                        <div class="col-sm-6">
                            <label for="" class="form-label">Cantidad</label>
                            <input value="{{ $venta->cantidad }}" type="number" class="form-control" id="cantidad"
                                name="cantidad" required>
                        </div>
                        <div class="col-sm-6">
                            <label for="" class="form-label">Fecha</label>
                            <input type="date" class="form-control" value="{{ $venta->fecha }}" name="fecha"
                                id="fecha">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="" class="form-label">Producto</label>
                        <input value="{{ $venta->descripcion }}" type="text" class="form-control" id="descripcion"
                            name="descripcion" required>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-sm-6">
                            <label for="" class="form-label">Precio de compra</label>
                            <input value="{{ $venta->precio_compra }}" type="number" class="form-control"
                                id="precio_compra" step="0.01" name="precio_compra" required>
                        </div>
                        <div class="col-sm-6">
                            <label for="" class="form-label">Precio de venta</label>
                            <input value="{{ $venta->precio_venta }}" type="number" class="form-control" id="precio_venta"
                                name="precio_venta" step="0.01" required>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <div class="col-sm-6">
                            <label for="" class="form-label">Forma de pago</label>
                            <select class="form-control" name="forma_pago" id="forma_pago" required>
                                <option disabled value="0" {{ $venta->forma_pago == 0 ? 'selected' : '' }}>
                                    Selecciona una forma de pago</option>
                                <option value="1" {{ $venta->forma_pago == 1 ? 'selected' : '' }}>Tarjeta de
                                    crédito</option>
                                <option value="2" {{ $venta->forma_pago == 2 ? 'selected' : '' }}>Tarjeta de
                                    débito</option>
                                <option value="3" {{ $venta->forma_pago == 3 ? 'selected' : '' }}>
                                    Transferencia</option>
                                <option value="4" {{ $venta->forma_pago == 4 ? 'selected' : '' }}>Efectivo
                                </option>
                            </select>
                        </div>
                        <div class="col-sm-6">
                            <label for="" class="form-label">Tienda</label>
                            <select class="form-control" id="tienda" name="tienda" required>
                                <option disabled selected value="">Selecciona una tienda</option>
                                <option value="Potreros" {{ $venta->tienda == 'Potreros' ? 'selected' : '' }}>Potreros
                                </option>
                                <option value="Guadalupano" {{ $venta->tienda == 'Guadalupano' ? 'selected' : '' }}>
                                    Guadalupano</option>
                            </select>
                        </div>
                    </div>

                    <input hidden value="{{ $venta->id }}" name="id" id="id">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </form>
            </div>
        </div>
    </div>
    <br>
@endsection
