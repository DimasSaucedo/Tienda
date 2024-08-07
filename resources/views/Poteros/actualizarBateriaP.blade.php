<style>
    .is-invalid {
        border-color: red;
    }
</style>

<div class="modal fade" id="modal-actualizar-{{ $ll->id }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h3 class="modal-title fs-5" id="exampleModalLabel">Actualizar Batería: <span
                        class="no-bold">{{ $ll->NoBateria }}</span></h3>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form class="needs-validation" novalidate id="actualizarBateriaFormP-{{ $ll->id }}"
                action="/actualizar_bateria_p" method="POST">
                @csrf
                @method('PUT')
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
                        <input class="form-control @error('marca') is-invalid @enderror" name="marca" id="marca"
                            style="text-transform: uppercase;" value="{{ old('marca', $ll->Marca) }}" required>
                        @error('marca')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Ingresa la cantidad: </label>
                        <input class="form-control @error('cantidad') is-invalid @enderror" type="number"
                            id="cantidad" name="cantidad" value="{{ old('cantidad', $ll->Cantidad) }}">
                        @error('cantidad')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-12">
                        <label class="form-label">Ingresa el precio de compra: </label>
                        <input class="form-control @error('precioCompra') is-invalid @enderror" type="number"
                            id="precioCompra" name="precioCompra" value="{{ old('precioCompra', $ll->PrecioCompra) }}"
                            required>
                        @error('precioCompra')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
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

<script>
    document.addEventListener('DOMContentLoaded', function() {

        const forms = document.querySelectorAll('form.needs-validation');
        //const fields = forms.querySelectorAll('input[required]');
        // let allFilled = true;

        forms.forEach(function(form) {
            form.addEventListener('submit', function(event) {
                if (!form.checkValidity()) {
                    event.preventDefault();
                    event.stopPropagation();
                    field.classList.add('is-invalid');
                }

                //form.classList.add('was-validated');
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
