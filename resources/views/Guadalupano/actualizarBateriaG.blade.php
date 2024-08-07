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
            <form id="actualizarBateriaFormP-{{ $ll->id }}" action="/actualizar_bateria_g" method="POST">
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
                            value="{{ $ll->Cantidad }}" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Ingresa el precio de compra: </label>
                        <input class="form-control" type="number" id="precioCompra" name="precioCompra"
                            value="{{ $ll->PrecioCompra }}" required>
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
        document.querySelectorAll('form[id^="actualizarBateriaFormP-"]').forEach(function(form) {
            form.addEventListener('submit', function(event) {
                // Selecciona todos los campos del formulario
                const fields = form.querySelectorAll('input[required]');

                // Verifica si todos los campos están llenos
                let allFilled = true;
                fields.forEach(function(field) {
                    if (!field.value) {
                        allFilled = false;
                        field.classList.add(
                        'is-invalid'); // Añade una clase para resaltar los campos vacíos
                    } else {
                        field.classList.remove('is-invalid');
                    }
                });

                // Si hay algún campo vacío, evita el envío del formulario
                if (!allFilled) {
                    event.preventDefault();
                    alert('Por favor, complete todos los campos.');
                }
            });
        });
    });
</script>
