@extends('layouts.app')
@section('content')
<div class="container mt-5 p-5" style="background: rgba(211, 211, 211, 0.381); border-radius: 10px">
    <h4>Datos del cliente</h4>
    <form action="/agregar_apartado" method="POST" novalidate>
        @csrf
        <div class="mb-3">
            {{-- <label for="basic-url" class="form-label">Nombre del cliente</label> --}}
            <div class="input-group">
                <span class="input-group-text" id="basic-addon3">Nombre del cliente</span>
                <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente"
                    aria-describedby="basic-addon3 basic-addon4" required>
            </div>
            {{-- <div class="form-text" id="basic-addon4">Example help text goes outside the input group.</div> --}}
        </div>

        <div class="mb-3">
            {{-- <label for="basic-url" class="form-label">Nombre del cliente</label> --}}
            <div class="input-group">
                <span class="input-group-text" id="basic-addon3">Telefono del cliente</span>
                <input type="text" class="form-control" id="telefono_cliente" name="telefono_cliente"
                    aria-describedby="basic-addon3 basic-addon4">
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
                    <option value="Guadalupano">Guadalupano</option>
                    <option value="Potreros">Potreros</option>
                </select>
            </div>
            {{-- <div class="form-text" id="basic-addon4">Example help text goes outside the input group.</div> --}}
        </div>
        {{--
        <hr>
        <h4>Productos</h4>
        <div class="mb-3">
            <div class="row">
                <div class="col-sm-2">
                    <div class="input-group ">
                        <span class="input-group-text" id="basic-addon3">Cantidad</span>
                        <input type="number" class="form-control" id="cantidad" name="cantidad"
                            aria-describedby="basic-addon3 basic-addon4">
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="input-group ">
                        <span class="input-group-text" id="basic-addon3">Productos</span>
                        <input type="text" class="form-control" id="productos" name="productos"
                            aria-describedby="basic-addon3 basic-addon4">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="input-group ">
                        <span class="input-group-text" id="basic-addon3">Precio Compra</span>
                        <input type="number" class="form-control" id="precio_compra" name="precio_compra"
                            aria-describedby="basic-addon3 basic-addon4">
                    </div>
                </div>
                <div class="col-sm-2">
                    <div class="input-group ">
                        <span class="input-group-text" id="basic-addon3">Precio Venta</span>
                        <input type="number" class="form-control" id="precio_venta" name="precio_venta"
                            aria-describedby="basic-addon3 basic-addon4">
                    </div>
                </div>
            </div>
        </div> --}}
        <hr>
        <button type="submit" class="btn btn-success">Agregar</button>
    </form>
</div>
@endsection