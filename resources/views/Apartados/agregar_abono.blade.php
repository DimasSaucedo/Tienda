@extends('layouts.app')
@section('content')
<div class="container mt-5 p-5" style="background: rgba(211, 211, 211, 0.381); border-radius: 10px">
    <h4>Abonos</h4>
    <form action="/guardar_abono" method="POST" novalidate>
        @csrf
        <hr>
        {{-- <h4>Abonos</h4> --}}
        <input type="hidden" name="nota_id" id="nota_id" value="{{ $nota_id }}">
        <div id="abonofecha-container">
            <div class="producto-item">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="input-group ">
                            <span class="input-group-text">Abono</span>
                            <input type="number" class="form-control" name="abono" id="abono" step="0.01" required>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="input-group ">
                            <span class="input-group-text">Fecha</span>
                            <input type="date" class="form-control" name="abono_fecha" id="abono_fecha" required>
                        </div>
                    </div>
                </div>
                <hr>
            </div>
        </div>
        <a href="/apartados" class="btn btn-warning mt-3">Omitir</a>
        {{-- <button type="button" class="btn btn-primary mt-3" onclick="addProduct()">Agregar Producto</button> --}}
        <button type="submit" class="btn btn-success mt-3">Enviar</button>
    </form>
</div>
<script>
    // Obtiene la fecha de hoy en el formato YYYY-MM-DD
    const today = new Date().toISOString().split('T')[0];
    
    // Establece el valor del input con la fecha de hoy
    document.getElementById('abono_fecha').value = today;
</script>
@endsection