@extends('layouts.app')

@section('content')


    <div class="container">

        <div class="d-flex justify-content-between mt-3 mb-3">
            <h4>Birlos</h4>

            <button class="btn btn-primary" onclick="abrirModal()">
                + Nuevo precio
            </button>
        </div>

        {{-- Tabla --}}
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle tabla-rines">
                <thead class="table-dark">
                    <tr>
                        <th>Medida</th>
                        <th>Barrenación</th>
                        <th>Tipo</th>
                        <th class="text-end">Compra</th>
                        <th class="text-end">Venta</th>
                        <th class="text-end">Ganancia</th>
                        <th>Acciones</th>
                    </tr>
                </thead>

                <tbody>
                   
                </tbody>

            </table>
        </div>
    </div>

    {{-- Modal vista previa de imagen --}}
    <div class="modal fade" id="modalImagen" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content border-0 shadow-lg overflow-hidden">

                <button type="button" class="btn-close position-absolute top-0 end-0 m-3 z-3 bg-white rounded-circle p-2"
                    data-bs-dismiss="modal" aria-label="Cerrar"></button>

                <div class="bg-light d-flex justify-content-center align-items-center p-3">
                    <img id="imgGrande" src="" alt="" class="img-fluid rounded"
                        style="max-height: 70vh; object-fit: contain;">
                </div>

                <div class="card-body p-4 d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="mb-1 fw-bold" id="imgTitulo"></h5>
                        <span class="text-muted" id="imgDetalle"></span>
                    </div>
                    <span class="badge bg-success fs-6" id="imgVenta"></span>
                </div>

            </div>
        </div>
    </div>


    {{-- Modal crear/editar --}}
    <div class="modal fade" id="modalPrecio" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" id="formPrecio" class="modal-content" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="metodo" value="POST">

                <div class="modal-header">
                    <h5 class="modal-title" id="tituloModal">Nuevo precio</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body row g-3">

                    <div class="col-6">
                        <label class="form-label">Rin (diámetro)</label>
                        <select name="rin" id="f_rin" class="form-select" required>
                            @foreach (range(10, 32) as $r)
                                <option value="{{ $r }}">{{ $r }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-6">
                        <label class="form-label">Ancho</label>
                        <select name="ancho" id="f_ancho" class="form-select" required>
                            @foreach (range(5, 15, 0.25) as $a)
                                <option value="{{ $a }}">{{ $a }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="col-6">
                        <label class="form-label">Barrenación</label>
                        <select name="barrenacion" id="f_barrenacion" class="form-select" required>
                            <option value="">Selecciona...</option>

                            <optgroup label="Sencillas">
                                <option value="4-98">4-98</option>
                                <option value="4-100">4-100</option>
                                <option value="4-108">4-108</option>
                                <option value="4-110">4-110</option>
                                <option value="4-114.3">4-114.3</option>
                                <option value="5-100">5-100</option>
                                <option value="5-105">5-105</option>
                                <option value="5-108">5-108</option>
                                <option value="5-110">5-110</option>
                                <option value="5-112">5-112</option>
                                <option value="5-114.3">5-114.3</option>
                                <option value="5-115">5-115</option>
                                <option value="5-120">5-120</option>
                                <option value="5-127">5-127</option>
                                <option value="5-130">5-130</option>
                                <option value="5-139.7">5-139.7</option>
                                <option value="6-114.3">6-114.3</option>
                                <option value="6-127">6-127</option>
                                <option value="6-135">6-135</option>
                                <option value="6-139.7">6-139.7</option>
                                <option value="8-165.1">8-165.1</option>
                                <option value="8-170">8-170</option>
                            </optgroup>

                            <optgroup label="Dobles">
                                <option value="4-100/4-108">4-100/4-108</option>
                                <option value="4-100/4-114.3">4-100/4-114.3</option>
                                <option value="5-100/5-108">5-100/5-108</option>
                                <option value="5-100/5-114.3">5-100/5-114.3</option>
                                <option value="5-108/5-114.3">5-108/5-114.3</option>
                                <option value="5-110/5-115">5-110/5-115</option>
                                <option value="5-112/5-120">5-112/5-120</option>
                                <option value="5-114.3/5-120">5-114.3/5-120</option>
                                <option value="6-127/6-139.7">6-127/6-139.7</option>
                            </optgroup>
                        </select>
                    </div>

                    <div class="col-6">
                        <label class="form-label">Tipo</label>
                        <select name="tipo" id="f_tipo" class="form-select" required>
                            <option value="Camioneta">Camioneta</option>
                            <option value="Carro">Carro</option>
                        </select>
                    </div>

                    <div class="col-6">
                        <label class="form-label">Precio compra</label>
                        <input type="number" step="0.01" min="0" name="precioCompra" id="f_compra"
                            class="form-control" required>
                    </div>

                    <div class="col-6">
                        <label class="form-label">Precio venta</label>
                        <input type="number" step="0.01" min="0" name="precioVenta" id="f_venta"
                            class="form-control" required>
                    </div>

                    {{-- Imagen (solo al crear; al editar se usa la tabla) --}}
                    <div class="col-12" id="grupoImagen">
                        <label class="form-label">Imagen (opcional)</label>
                        <input type="file" name="imagen_rin" id="f_imagen_rin" class="form-control"
                            accept=".png,.jpg,.jpeg,.webp">
                    </div>

                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>


    {{-- JavaScript --}}
    <script>
        // Modal crear / editar
        function abrirModal(r = null) {
            const form = document.getElementById('formPrecio');
            const editando = r !== null;

            form.reset();
            document.getElementById('f_imagen_rin').value = '';

            form.action = editando ?
                "{{ url('precio-rines') }}/" + r.id :
                "{{ route('precio_rines.store') }}";

            document.getElementById('metodo').value = editando ? 'PUT' : 'POST';
            document.getElementById('tituloModal').innerText = editando ? 'Editar precio' : 'Nuevo precio';
            document.getElementById('grupoImagen').classList.toggle('d-none', editando);

            if (editando) {
                f_rin.value = r.rin;
                f_ancho.value = parseFloat(r.ancho);
                f_barrenacion.value = r.barrenacion ?? '';
                f_tipo.value = r.tipo ?? 'Carro';
                f_compra.value = r.precioCompra;
                f_venta.value = r.precioVenta;
            }

            bootstrap.Modal.getOrCreateInstance(document.getElementById('modalPrecio')).show();
        }

        // Botones "Editar"
        document.querySelectorAll('.btn-editar').forEach(btn => {
            btn.addEventListener('click', () => abrirModal(JSON.parse(btn.dataset.registro)));
        });

        // Confirmaciones SweetAlert
        function confirmarEnvio(selector, titulo, texto) {
            document.querySelectorAll(selector).forEach(form => {
                form.addEventListener('submit', e => {
                    e.preventDefault();

                    Swal.fire({
                        title: titulo,
                        text: texto,
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#dc3545',
                        cancelButtonColor: '#6c757d',
                        confirmButtonText: 'Sí, eliminar',
                        cancelButtonText: 'Cancelar'
                    }).then(result => {
                        if (result.isConfirmed) form.submit();
                    });
                });
            });
        }

        // Vista previa de imagen
        document.querySelectorAll('.img-zoom').forEach(img => {
            img.addEventListener('click', () => {
                document.getElementById('imgGrande').src = img.dataset.src;
                document.getElementById('imgGrande').alt = img.dataset.titulo;
                document.getElementById('imgTitulo').innerText = img.dataset.titulo;
                document.getElementById('imgDetalle').innerText = img.dataset.detalle;
                document.getElementById('imgVenta').innerText = img.dataset.venta;

                bootstrap.Modal.getOrCreateInstance(document.getElementById('modalImagen')).show();
            });
        });

        confirmarEnvio('.form-eliminar', '¿Eliminar este precio?', 'Dejará de mostrarse en la lista.');
        confirmarEnvio('.form-eliminar-imagen', '¿Eliminar imagen?', 'La imagen se eliminará permanentemente.');
    </script>


    {{-- Mensaje de éxito --}}
    @if (session('success'))
        <script>
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: @json(session('success')),
                showConfirmButton: false,
                timer: 2500,
                timerProgressBar: true
            });
        </script>
    @endif


    {{-- Mensaje de error --}}
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: @json(session('error'))
            });
        </script>
    @endif


    {{-- Errores de validación --}}
    @if ($errors->any())
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Revisa los datos',
                html: @json(collect($errors->all())->map(fn($e) => e($e))->implode('<br>'))
            });
        </script>
    @endif
@endsection
