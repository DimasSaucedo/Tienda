@extends('layouts.app')
@section('content')
<div class="container mt-5 p-5" style="background: rgba(211, 211, 211, 0.381); border-radius: 10px">
    <h4>Datos del Producto</h4>
    <form action="/guardar_producto" method="POST" novalidate>
        @csrf
        <hr>
        <h4>Productos</h4>
        <input type="hidden" name="nota_id" id="nota_id" value="{{ session('nota_id') }}">
        <div id="productos-container">
            <div class="producto-item">
                <div class="row">
                    <div class="col-sm-2">
                        <div class="input-group ">
                            <span class="input-group-text">Cantidad</span>
                            <input type="number" class="form-control" name="cantidad[]" id="cantidad[]" required>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group ">
                            <span class="input-group-text">Productos</span>
                            <input type="text" class="form-control" name="productos[]" id="productos[]" required>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="input-group ">
                            <span class="input-group-text">Precio Compra</span>
                            <input type="number" class="form-control" name="precio_compra[]" id="precio_compra[]"
                                step="0.01" required>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="input-group ">
                            <span class="input-group-text">Precio Venta</span>
                            <input type="number" class="form-control" name="precio_venta[]" name="precio_venta[]"
                                step="0.01" required>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-danger btn-sm mt-3" onclick="removeProduct(this)">Eliminar</button>
                <hr>
            </div>
        </div>
        <button type="button" class="btn btn-primary mt-3" onclick="addProduct()">Agregar Producto</button>
        <button type="submit" class="btn btn-success mt-3">Enviar</button>
    </form>
</div>

<script>
    function addProduct() {
    const productContainer = document.getElementById('productos-container');
    const newProduct = document.createElement('div');
    newProduct.classList.add('producto-item');
    newProduct.innerHTML = `
        <div class="row">
            <div class="col-sm-2">
                <div class="input-group">
                    <span class="input-group-text">Cantidad</span>
                    <input type="number" class="form-control" name="cantidad[]" required>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="input-group">
                    <span class="input-group-text">Productos</span>
                    <input type="text" class="form-control" name="productos[]" required>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="input-group">
                    <span class="input-group-text">Precio Compra</span>
                    <input type="number" class="form-control" name="precio_compra[]" required>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="input-group">
                    <span class="input-group-text">Precio Venta</span>
                    <input type="number" class="form-control" name="precio_venta[]" required>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-danger btn-sm mt-2" onclick="removeProduct(this)">Eliminar</button>
        <hr>`;
    productContainer.appendChild(newProduct);
}

function removeProduct(element) {
    element.parentElement.remove();
}
</script>
@endsection