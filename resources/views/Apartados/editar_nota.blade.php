@extends('layouts.app')
@section('content')
<div class="container mt-5 p-5 mb-5" style="background: rgba(153, 153, 153, 0.304); border-radius: 10px">
    <h4>Datos del cliente</h4>
    <form action="/actualizar_nota" method="POST" novalidate>
        @csrf
        <div class="mb-3">
            {{-- <label for="basic-url" class="form-label">Nombre del cliente</label> --}}
            <div class="input-group">
                <span class="input-group-text" id="basic-addon3">Nombre del cliente</span>
                <input type="text" class="form-control" id="nombre_cliente" name="nombre_cliente"
                    aria-describedby="basic-addon3 basic-addon4" value="{{$nota->nombre_cliente}}" required>
            </div>
            {{-- <div class="form-text" id="basic-addon4">Example help text goes outside the input group.</div> --}}
        </div>

        <div class="mb-3">
            {{-- <label for="basic-url" class="form-label">Nombre del cliente</label> --}}
            <div class="input-group">
                <span class="input-group-text" id="basic-addon3">Telefono del cliente</span>
                <input type="text" class="form-control" id="telefono_cliente" name="telefono_cliente"
                    aria-describedby="basic-addon3 basic-addon4" value="{{$nota->telefono_cliente}}">
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
                    <option value="Guadalupano" @if($nota->tienda == "Guadalupano") selected @endif>Guadalupano</option>
                    <option value="Potreros" @if($nota->tienda == "Potreros") selected @endif>Potreros</option>
                </select>
            </div>
            {{-- <div class="form-text" id="basic-addon4">Example help text goes outside the input group.</div> --}}
        </div>
        <hr>
        <h4>Productos</h4>
        <div id="productos-container">
            @foreach ($productos as $item)
            <div class="producto-item">
                <div class="row">
                    <input type="hidden" value="{{$item->id}}" name="id_producto[]" id="id_producto[]">
                    <div class="col-sm-2">
                        <div class="input-group ">
                            <span class="input-group-text">Cantidad</span>
                            <input type="number" class="form-control" name="cantidad[]" id="cantidad[]"
                                value="{{$item->cantidad}}" required>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group ">
                            <span class="input-group-text">Productos</span>
                            <input type="text" class="form-control" name="productos[]" id="productos[]"
                                value="{{$item->producto}}" required>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="input-group ">
                            <span class="input-group-text">Precio Compra</span>
                            <input type="number" class="form-control" name="precio_compra[]" id="precio_compra[]"
                                value="{{$item->precio_compra}}" step="0.01" required>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="input-group ">
                            <span class="input-group-text">Precio Venta</span>
                            <input type="number" class="form-control" name="precio_venta[]" name="precio_venta[]"
                                value="{{$item->precio_venta}}" step="0.01" required>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn btn-danger mt-3" onclick="removeProduct(this)">Eliminar</button>
                <hr>
            </div>
            @endforeach
        </div>
        <button type="button" class="btn btn-primary mt-3" onclick="addProduct()">Agregar Producto</button>

        <hr>
        <h4>Abonos</h4>
        <div id="abonos-container">
            @if($abonos->count()>0)
            @foreach ($abonos as $ab)
            <div class="abonos-item">
                <div class="row">
                    <input type="hidden" value="{{$ab->id}}" name="id_abono[]" id="id_abono[]">
                    <div class="col-sm-4">
                        <div class="input-group ">
                            <span class="input-group-text">Abono</span>
                            <input type="number" class="form-control" name="abono[]" id="abono[]" value="{{$ab->abono}}"
                                step="0.01" required>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group ">
                            <span class="input-group-text">Fecha</span>
                            <input type="date" class="form-control" name="abono_fecha[]" id="abono_fecha[]"
                                value="{{$ab->fecha}}" required>
                        </div>
                    </div>

                </div>
                <button type="button" class="btn btn-danger mt-3" onclick="removeProductAbono(this)">Eliminar</button>
                <hr>
            </div>
            @endforeach
            @endif

        </div>
        <button type="button" class="btn btn-primary mt-3" onclick="addProductAbono()">Agregar Abono</button>
        <hr>

        <div>
            <input type="hidden" name="productos_eliminados" id="productos_eliminados" value="">
            <input type="hidden" name="abonos_eliminados" id="abonos_eliminados" value="">

            <input type="hidden" value="{{$nota->id}}" id="id_nota" name="id_nota">
            <button type="submit" class="btn btn-success mt-3">Enviar</button>
        </div>
    </form>
</div>

<script>
    function addProduct() {
    const productContainer = document.getElementById('productos-container');
    const newProduct = document.createElement('div');
    newProduct.classList.add('producto-item');
    newProduct.innerHTML = `
        <div class="row">
             <input type="hidden" value="-" name="id_producto[]" id="id_producto[]">
            <div class="col-sm-2">
                <div class="input-group">
                    <span class="input-group-text">Cantidad</span>
                    <input type="number" class="form-control" name="cantidad[]" value="" required>
                </div>
            </div>
            <div class="col-sm-4">
                <div class="input-group">
                    <span class="input-group-text">Productos</span>
                    <input type="text" class="form-control" name="productos[]" value="" required>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="input-group">
                    <span class="input-group-text">Precio Compra</span>
                    <input type="number" class="form-control" name="precio_compra[]" value="" step="0.01" required>
                </div>
            </div>
            <div class="col-sm-3">
                <div class="input-group">
                    <span class="input-group-text">Precio Venta</span>
                    <input type="number" class="form-control" name="precio_venta[]" value="" step="0.01" required>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-danger btn-sm mt-2" onclick="removeProduct(this)">Eliminar</button>
        <hr>`;
    productContainer.appendChild(newProduct);
}

function removeProduct(element) {
    const productID = element.parentElement.querySelector('[name="id_producto[]"]').value;

    if (productID !== "-") {
        // Agregar el ID del producto eliminado al campo oculto
        const productosEliminados = document.getElementById('productos_eliminados');
        productosEliminados.value += productID + ",";
    }

    element.parentElement.remove();
}
</script>

<script>
    function addProductAbono() {
    const productContainerAbono = document.getElementById('abonos-container');
    const newProduct = document.createElement('div');
    newProduct.classList.add('abonos-item');
    newProduct.innerHTML = `
        <div class="row">
              <input type="hidden" value="-" name="id_abono[]" id="id_abono[]" value="-">
                    <div class="col-sm-4">
                        <div class="input-group ">
                            <span class="input-group-text">Abono</span>
                            <input type="number" class="form-control" name="abono[]" id="abono[]" value="" step="0.01" required>
                        </div>
                    </div>
                    <div class="col-sm-4">
                        <div class="input-group ">
                            <span class="input-group-text">Fecha</span>
                            <input type="date" class="form-control" name="abono_fecha[]" id="abono_fecha[]" value="" required>
                        </div>
                    </div>
                     
                </div>
       <button type="button" class="btn btn-danger mt-3"
                            onclick="removeProductAbono(this)">Eliminar</button>
        <hr>`;
        productContainerAbono.appendChild(newProduct);
}

function removeProductAbono(element) {
    const abonoID = element.parentElement.querySelector('[name="id_abono[]"]').value;

if (abonoID !== "-") {
    // Agregar el ID del producto eliminado al campo oculto
    const abonosEliminados = document.getElementById('abonos_eliminados');
    abonosEliminados.value += abonoID + ",";
}

element.parentElement.remove();
}
</script>


<script>
    // Obtiene la fecha de hoy en el formato YYYY-MM-DD
    const today = new Date().toISOString().split('T')[0];
    
    // Establece el valor del input con la fecha de hoy
    document.getElementById('abono_fecha').value = today;
</script>
@endsection