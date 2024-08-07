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
                <form id="agregarBateriaForm" action="/agregarBateriaG" method="POST">
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
                        <input class="form-control" type="number" id="precioCompra" name="precioCompra" required>
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

        document.getElementById('agregarLlantaForm').addEventListener('submit', function(event) {
            // Selecciona todos los campos del formulario
            const fields = document.querySelectorAll('#agregarLlantaForm input[required]');

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
</script>
