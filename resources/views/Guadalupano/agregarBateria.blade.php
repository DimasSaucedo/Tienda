<style>
    .is-invalid {
        border-color: red;
    }
</style>

<div class="modal fade" id="modal-agregar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar Bateria</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate id="agregarBateriaForm" action="/agregarBateriaG" method="POST">
                    @csrf
                    <div class="col-md-12">
                        <label class="form-label">Ingresa el No. Bateria: </label>
                        <input class="form-control" name="nobateria" id="nobateria" required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Ingresa la marca: </label>
                        <input class="form-control" name="marca" id="marca" style="text-transform: uppercase;"
                            required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Ingresa la cantidad: </label>
                        <input class="form-control" type="number" id="cantidad" name="cantidad">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Ingresa el precio de compra: </label>
                        <input class="form-control" type="number" id="precioCompra" name="precioCompra" step="0.01" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" form="agregarBateriaForm">Guardar</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Convierte el valor de la marca y letra a mayúsculas mientras se escribe
        document.getElementById('marca').addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });

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
