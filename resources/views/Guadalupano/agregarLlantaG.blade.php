<style>
    .is-invalid {
        border-color: red;
    }
</style>

<div class="modal fade" id="modal-agregar">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="exampleModalLabel">Agregar llanta</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form class="needs-validation" novalidate id="agregarLlantaFormG" action="/agregarLlantaG" method="POST">
                    @csrf
                    <div class="col-md-12">
                        <label class="form-label">Ingresa la medida: </label>
                        <input class="form-control" placeholder="175-70-13" name="medida" id="medida" required>
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
                        <label class="form-label">Ingresa la letra: </label>
                        <input class="form-control" id="letra" name="letra" style="text-transform: uppercase;">
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Ingresa el precio de compra: </label>
                        <input class="form-control" type="number" id="precioCompra" name="precioCompra" step="0.01"
                            required>
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Ingresa el precio de venta: </label>
                        <input class="form-control" type="number" id="precioVenta" name="precioVenta" step="0.01"
                            required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                <button type="submit" class="btn btn-primary" form="agregarLlantaFormG">Guardar</button>
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
        document.getElementById('letra').addEventListener('input', function() {
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
