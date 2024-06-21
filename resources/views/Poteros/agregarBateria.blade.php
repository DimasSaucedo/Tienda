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
                <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" novalidate id="agregarBateriaForm" action="/agregarBateria" method="POST">
                @csrf
                <div class="modal-body">

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
                        <input class="form-control" type="number" id="precioCompra" name="precioCompra" required>
                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary" form="agregarBateriaForm">Guardar</button>
                </div>
            </form>
        </div>
    </div>
</div>
<br>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Convierte el valor de la marca a mayúsculas mientras se escribe
        document.getElementById('marca').addEventListener('input', function() {
            this.value = this.value.toUpperCase();
        });

        document.getElementById('agregarBateriaForm').addEventListener('submit', function(event) {
            const form = this;
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

            } else {
                form.classList.add('was-validated');
            }
        });
    });
</script>
