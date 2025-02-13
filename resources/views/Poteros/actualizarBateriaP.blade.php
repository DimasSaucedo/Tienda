<style>
    .is-invalid {
        border-color: red;
    }
</style>

<div class="modal fade" id="modal-actualizar-{{ $ll->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="exampleModalLabel">Actualizar Batería: <span class="no-bold">{{
    $ll->NoBateria }}</span></h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" novalidate id="actualizarBateriaFormP-{{ $ll->id }}"
                action="/actualizar_bateria_p" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="col-md-12">
                        <label class="form-label">Ingresa el No. Batería: </label>
                        <input class="form-control @error('nobateria') is-invalid @enderror" name="nobateria"
                            id="nobateria" value="{{ old('nobateria', $ll->NoBateria) }}" required>
                        @error('nobateria')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Ingresa la marca: </label>
                        <select class="form-select" name="marca" id="marca">
                            <option value="" disabled selected>Seleccionar una opción</option>
                            @foreach ($cat_marcas as $item)
                                <option value="{{$item->nombre}}" @if ($item->nombre == $ll->Marca) selected @endif>
                                    {{$item->nombre}}
                                </option>
                            @endforeach
                        </select>
                        {{-- @error('marca')
                        <div class="invalid-feedback">{{ $message }}</div>
                        @enderror --}}
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Ingresa la cantidad: </label>
                        <input class="form-control @error('cantidad') is-invalid @enderror" type="number" id="cantidad"
                            name="cantidad" value="{{ old('cantidad', $ll->Cantidad) }}">
                        @error('cantidad')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Ingresa el precio de compra: </label>
                        <input class="form-control @error('precioCompra') is-invalid @enderror" type="number"
                            id="precioCompra" name="precioCompra" value="{{ old('precioCompra', $ll->PrecioCompra) }}"
                            step="0.01" required>
                        @error('precioCompra')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12" style="display: none" id="precioVentaContainer">
                        <label class="form-label">Ingresa el precio de venta: </label>
                        <input class="form-control" type="number" id="precioVenta" name="precioVenta" step="0.01"
                            value="{{ old('precioVenta', $ll->PrecioVenta) }}">
                    </div>
                    <input type="hidden" name="id" id="id" value="{{ $ll->id }}" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.dataTables.js"></script>
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
<script>
    $(document).on('change', '#marca', function () {
        if ($(this).val() == "POWER-CONECTION") {
            $('#precioVentaContainer').css('display', 'block');
            $('#precioVenta').attr('required', true); // Agregar required
        } else {
            $('#precioVentaContainer').css('display', 'none');
            $('#precioVenta').removeAttr('required'); // Quitar required
        }
    });

    document.addEventListener('DOMContentLoaded', function () {

        const forms = document.querySelectorAll('form.needs-validation');
        //const fields = forms.querySelectorAll('input[required]');
        // let allFilled = true;

        forms.forEach(function (form) {
            form.addEventListener('submit', function (event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                    field.classList.add('is-invalid');
                }

                //form.classList.add('was-validated');
            }, false);

            const marcaInput = form.querySelector('input[name="marca"]');
            if (marcaInput) {
                marcaInput.addEventListener('input', function () {
                    this.value = this.value.toUpperCase();
                });
            }
        });
    });
</script>