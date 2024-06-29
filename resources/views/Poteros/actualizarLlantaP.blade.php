<style>
    .is-invalid {
        border-color: red;
    }
</style>

<div class="modal fade" id="modal-actualizar-{{ $ll->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="exampleModalLabel">Actualizar llanta: <span
                        class="no-bold">{{ $ll->Medida }}</span></h3>
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" novalidate id="actualizarLlantaFormP-{{ $ll->id }}"
                action="/actualizar_llanta_p" method="POST">
                @csrf
                <div class="modal-body">
                    @method('PUT')
                    <div class="col-md-12">
                        <label class="form-label">Ingresa la medida: </label>
                        <input class="form-control" placeholder="175-70-13" name="medida" id="medida"
                            value="{{ $ll->Medida }}" required>
                        @error('medida')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Ingresa la marca: </label>
                        <input class="form-control" name="marca" id="marca" style="text-transform: uppercase;"
                            value="{{ $ll->Marca }}" required>
                        @error('marca')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Ingresa la cantidad: </label>
                        <input class="form-control" type="number" id="cantidad" name="cantidad"
                            value="{{ $ll->Cantidad }}">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Ingresa la letra: </label>
                        <input class="form-control" id="letra" name="letra" value="{{ $ll->Letra }}"
                            style="text-transform: uppercase;">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Ingresa el precio de compra: </label>
                        <input class="form-control" type="number" id="precioCompra" name="precioCompra"
                            value="{{ $ll->PrecioCompra }}" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Ingresa el precio de venta: </label>
                        <input class="form-control" type="number" id="precioVenta" name="precioVenta"
                            value="{{ $ll->PrecioVenta }}" required>
                    </div>
                    <input hidden name="id" id="id" value="{{ $ll->id }}">

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const forms = document.querySelectorAll('form.needs-validation');

        forms.forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();

                    const invalidFields = form.querySelectorAll(':invalid');
                    invalidFields.forEach(field => {
                        field.classList.add('is-invalid');
                    });
                }
            }, false);

            const marcaInput = form.querySelector('input[name="marca"]');
            if (marcaInput) {
                marcaInput.addEventListener('input', function() {
                    this.value = this.value.toUpperCase();
                });
            }
        });
    });
</script>
