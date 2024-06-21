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
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" novalidate id="actualizarBateriaFormP-{{ $ll->id }}"
                action="/actualizar_bateria_p" method="POST">
                @csrf
                <div class="modal-body">
                    @method('PUT')
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
                            value="{{ $ll->Cantidad }}">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Ingresa el precio de compra: </label>
                        <input class="form-control" type="number" id="precioCompra" name="precioCompra"
                            value="{{ $ll->PrecioCompra }}" required>
                    </div>
                    <input hidden name="id" id="id" value="{{ $ll->id }}">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
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
            const formId = form.id;

            form.querySelector(`#marca-${formId.split('-').pop()}`).addEventListener('input',
                function() {
                    this.value = this.value.toUpperCase();
                });

            form.addEventListener('submit', function(event) {
                const fields = form.querySelectorAll('input[required]');
                let allFilled = true;

                fields.forEach(function(field) {
                    if (!field.value) {
                        allFilled = false;
                        field.classList.add('is-invalid');
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });

                if (!allFilled) {
                    event.preventDefault();
                    event.stopPropagation();
                    //   alert('Por favor, complete todos los campos.');
                } else {
                    form.classList.add('was-validated');
                }
            });
        });
    });
</script>
