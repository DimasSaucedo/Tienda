<style>
    .is-invalid {
        border-color: red;
    }

    .no-bold {
        font-weight: normal;
    }
</style>

<div class="modal fade" id="modal-actualizar-{{ $ll->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="exampleModalLabel">Actualizar Bateria: <span
                        class="no-bold">{{ $ll->NoBateria }}</span></h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" novalidate id="actualizarBateriaFormP-{{ $ll->id }}"
                action="/actualizar_bateria_g" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="col-md-12">
                        <label class="form-label">Ingresa el No. Bateria: </label>
                        <input class="form-control" name="nobateria" id="nobateria" value="{{ $ll->NoBateria }}"
                            required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Ingresa la marca: </label>
                        <input class="form-control" name="marca" id="marca" style="text-transform: uppercase;"
                            value="{{ $ll->Marca }}" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Ingresa la cantidad: </label>
                        <input class="form-control" type="number" id="cantidad" name="cantidad"
                            value="{{ $ll->Cantidad }}" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Ingresa el precio de compra: </label>
                        <input class="form-control" type="number" id="precioCompra" name="precioCompra"
                            value="{{ $ll->PrecioCompra }}" step="0.01" required>
                    </div>
                    <input hidden name="id" id="id" value="{{ $ll->id }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary"
                        form="actualizarBateriaFormP-{{ $ll->id }}">Actualizar</button>
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
