@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between mt-3 mb-3">
            <h4>Birlos</h4>

            <button class="btn btn-primary" onclick="abrirModal()">
                + Nuevo
            </button>
        </div>

        {{-- Tabla (DataTables Responsive: en celular oculta columnas y muestra el botón "+") --}}
        <table id="tablaBirlos" class="table table-striped table-hover align-middle nowrap" style="width:100%">
            <thead class="table-dark">
                <tr>
                    <th class="text-center">Imagen</th>
                    <th class="text-center">Cantidad</th>
                    <th class="text-center">Juego</th>
                    <th class="text-center">Medida</th>
                    <th class="text-center">Tipo</th>
                    <th class="text-center">Estilo</th>
                    <th class="text-center">Compra</th>
                    <th class="text-center">Venta</th>
                    <th class="text-center">Ganancia</th>
                    <th class="text-center">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($birlos as $br)
                    <tr>
                        <td class="text-center">
                            @if ($br->imagen)
                                {{-- Al hacer click se abre en grande (modal #modalImagen) --}}
                                <img src="{{ asset('storage/' . $br->imagen) }}"
                                    data-src="{{ asset('storage/' . $br->imagen) }}" data-titulo="{{ $br->medida }}"
                                    data-detalle="{{ $br->tipo }} · {{ $br->estilo }}"
                                    data-venta="${{ number_format($br->precio_venta, 2) }}" alt="Birlo"
                                    class="img-thumbnail img-zoom"
                                    style="width:60px;height:60px;object-fit:cover;cursor:pointer;" loading="lazy"
                                    decoding="async">
                            @else
                                <span class="text-muted small">Sin imagen</span>
                            @endif
                        </td>
                        <td class="text-center">{{ $br->cantidad }}</td>
                        <td class="text-center">
                            @if ($br->juego == 1)
                                <span class="badge text-bg-success">Si</span>
                            @else
                                <span class="badge text-bg-danger">No</span>
                            @endif
                        </td>
                        <td class="text-center">{{ $br->medida }}</td>
                        <td class="text-center">{{ $br->tipo }}</td>
                        <td class="text-center">{{ $br->estilo }}</td>
                        <td class="text-center">$ {{ $br->precio_compra }}</td>
                        <td class="text-center">$ {{ $br->precio_venta }}</td>
                        <td class="text-center text-success">
                            ${{ number_format($br->precio_venta - $br->precio_compra, 2) }}
                        </td>
                        <td class="text-center">
                            <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                <div class="btn-group" role="group">
                                    <button type="button" class="btn btn-primary dropdown-toggle" data-bs-toggle="dropdown"
                                        aria-expanded="false">
                                        <i class="fa-solid fa-gear"></i>
                                    </button>
                                    <ul class="dropdown-menu">
                                        <li>
                                            <button type="button" class="dropdown-item btn-editar"
                                                data-registro="{{ json_encode($br->only(['id', 'cantidad', 'medida', 'tipo', 'estilo', 'precio_compra', 'precio_venta', 'juego', 'imagen'])) }}">
                                                <i class="bi bi-pencil me-2"></i>
                                                Editar
                                            </button>
                                        </li>
                                        <li>
                                            <form action="/eliminar_birlo" method="POST" class="form-eliminar">
                                                @csrf
                                                <input type="hidden" value="{{ $br->id }}" name="id">
                                                <input type="hidden" value="Potreros" name="tienda">
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="bi bi-trash me-2"></i>
                                                    Eliminar registro
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
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
    <div class="modal fade" id="modalBirlos" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <form method="POST" id="formBirlos" class="modal-content" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="_method" id="metodo" value="POST">
                <input type="hidden" name="id" id="birlo_id" value="">

                <div class="modal-header">
                    <h5 class="modal-title" id="tituloModal">Nuevos Birlos</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body row g-3">

                    <div class="col-6">
                        <label class="form-label">Cantidad</label>
                        <input type="number" step="0.01" min="0" name="cantidad" id="f_cantidad"
                            class="form-control" required>
                    </div>

                    <div class="col-6">
                        <label class="form-label">Medida</label>
                        <select name="medida" id="f_medida" class="form-select" required>
                            <option value="12x1.25">12x1.25</option>
                            <option value="12x1.50">12x1.50</option>
                            <option value="12x1.75">12x1.75</option>
                            <option value="14x1.25">14x1.25</option>
                            <option value="14x1.50">14x1.50</option>
                            <option value="14x2.00">14x2.00</option>
                            <option value="9/16">9/16</option>
                            <option value="1/2x20">1/2x20</option>
                        </select>
                    </div>

                    <div class="col-6">
                        <label class="form-label">Tipo</label>
                        <select name="tipo" id="f_tipo" class="form-select" required>
                            <option value="Tuerca tapada">Tuerca tapada</option>
                            <option value="Tuerca destapada">Tuerca destapada</option>
                            <option value="Tornillo">Tornillo</option>
                            <option value="Tuerca tunning">Tuerca tunning</option>
                            <option value="Tuerca tunning pico">Tuerca tunning pico</option>
                            <option value="Tornillo tunning">Tornillo tunning</option>
                            <option value="Tuerca De Pico Camioneta">Tuerca De Pico Camioneta</option>
                        </select>
                    </div>

                    <div class="col-6">
                        <label class="form-label">Estilo</label>
                        <select name="estilo" id="f_estilo" class="form-select" required>
                            <option value="Tuerca Larga">Tuerca Larga</option>
                            <option value="Tuerca Corta">Tuerca Corta</option>
                            <option value="Cromadas">Cromadas</option>
                            <option value="Color">Color</option>
                        </select>
                    </div>

                    <div class="col-6">
                        <label class="form-label">Precio compra</label>
                        <input type="number" step="0.01" min="0" name="precio_compra" id="f_compra"
                            class="form-control" required>
                    </div>

                    <div class="col-6">
                        <label class="form-label">Precio venta</label>
                        <input type="number" step="0.01" min="0" name="precio_venta" id="f_venta"
                            class="form-control" required>
                    </div>

                    <div class="col-12">
                        <label for="f_juego" class="form-label">¿Es juego?</label>
                        <div class="form-check form-switch">
                            {{-- Para que se envíe "0" cuando el switch está apagado --}}
                            <input type="hidden" name="es_juego" value="0">
                            <input class="form-check-input" type="checkbox" role="switch" id="f_juego"
                                name="es_juego" value="1">
                            <label class="form-check-label" for="f_juego" id="es_juego_label">No</label>
                        </div>
                    </div>

                    {{-- Imagen: tomar foto con la cámara o elegir de la galería --}}
                    <div class="col-12">
                        <label class="form-label">Imagen del producto</label>

                        {{-- Input real (oculto). Los botones le activan o quitan "capture" antes de abrirlo --}}
                        <input class="d-none" type="file" id="f_imagen" name="imagen"
                            accept="image/png, image/jpeg, image/webp">

                        <div class="d-flex gap-2">
                            <button type="button" class="btn btn-outline-primary flex-fill"
                                onclick="elegirImagen(true)">
                                <i class="bi bi-camera me-2"></i>Tomar foto
                            </button>
                            <button type="button" class="btn btn-outline-secondary flex-fill"
                                onclick="elegirImagen(false)">
                                <i class="bi bi-images me-2"></i>Galería
                            </button>
                        </div>

                        <div id="preview_imagen_wrap" class="mt-3 d-none">
                            <div class="d-flex align-items-center gap-3">
                                <img id="preview_imagen" class="img-thumbnail"
                                    style="width:90px;height:90px;object-fit:cover;" alt="Vista previa">
                                <div>
                                    <div id="preview_texto" class="small text-muted"></div>
                                    <button type="button" id="btn_quitar_imagen"
                                        class="btn btn-sm btn-link text-danger p-0 d-none" onclick="quitarImagenNueva()">
                                        Quitar selección
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>

                    <input type="hidden" value="Potreros" name="tienda" id="f_tienda">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        Cancelar
                    </button>
                    <button type="submit" class="btn btn-primary" id="btn_guardar">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>


    {{-- Librerías DataTables (si tu layouts.app ya carga jQuery, quita la línea de jQuery) --}}
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/3.0.2/css/responsive.dataTables.css">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/3.0.2/js/responsive.dataTables.js"></script>


    {{-- JavaScript --}}
    <script>
        // Tabla responsive
        $(document).ready(function() {
            $('#tablaBirlos').DataTable({
                responsive: true,
                paging: false,
                ordering: false,
                stateSave: true,
                language: {
                    url: "/assets/lib/datatable/es.json"
                },
                columnDefs: [
                    // Menor número = se oculta al último en pantallas chicas
                    {
                        responsivePriority: 1,
                        targets: -1
                    }, // Acciones (siempre visible)
                    {
                        responsivePriority: 2,
                        targets: 3
                    }, // Medida
                    {
                        responsivePriority: 3,
                        targets: 1
                    }, // Cantidad
                    {
                        responsivePriority: 4,
                        targets: 7
                    }, // Venta
                    {
                        responsivePriority: 5,
                        targets: 0
                    }, // Imagen
                    {
                        responsivePriority: 6,
                        targets: 4
                    }, // Tipo
                    {
                        responsivePriority: 7,
                        targets: 5
                    }, // Estilo
                    {
                        responsivePriority: 8,
                        targets: 2
                    }, // Juego
                    {
                        responsivePriority: 9,
                        targets: 6
                    }, // Compra
                    {
                        responsivePriority: 10,
                        targets: 8
                    } // Ganancia
                ]
            });
        });

        // ---------- Imagen: cámara / galería ----------
        const inputImagen = document.getElementById('f_imagen');
        let imagenActualUrl = null; // imagen que ya tiene el registro (al editar)
        let urlPreviewNueva = null; // object URL de la foto recién elegida

        // Abre la cámara (capture) o la galería, según el botón
        function elegirImagen(usarCamara) {
            if (usarCamara) {
                inputImagen.setAttribute('capture', 'environment'); // cámara trasera
            } else {
                inputImagen.removeAttribute('capture');
            }
            inputImagen.click();
        }

        // Reduce la foto en el navegador (máx. 1600 px, JPEG 85 %) para que suba rápido
        async function comprimirImagen(file, maxLado = 1600, calidad = 0.85) {
            const url = URL.createObjectURL(file);
            try {
                const img = await new Promise((resolve, reject) => {
                    const i = new Image();
                    i.onload = () => resolve(i);
                    i.onerror = reject;
                    i.src = url;
                });

                const escala = Math.min(1, maxLado / Math.max(img.naturalWidth, img.naturalHeight));

                // Si ya es chica, no la tocamos
                if (escala === 1 && file.size < 1.5 * 1024 * 1024) return file;

                const canvas = document.createElement('canvas');
                canvas.width = Math.round(img.naturalWidth * escala);
                canvas.height = Math.round(img.naturalHeight * escala);
                canvas.getContext('2d').drawImage(img, 0, 0, canvas.width, canvas.height);

                const blob = await new Promise(resolve => canvas.toBlob(resolve, 'image/jpeg', calidad));
                if (!blob || blob.size >= file.size) return file;

                return new File([blob], 'foto.jpg', {
                    type: 'image/jpeg'
                });
            } finally {
                URL.revokeObjectURL(url);
            }
        }

        // Muestra la vista previa (imagen actual o recién elegida)
        function mostrarPreview(url, esNueva) {
            const wrap = document.getElementById('preview_imagen_wrap');
            const preview = document.getElementById('preview_imagen');

            if (!url) {
                preview.removeAttribute('src');
                wrap.classList.add('d-none');
                return;
            }

            preview.src = url;
            document.getElementById('preview_texto').textContent = esNueva ?
                'Imagen nueva seleccionada.' :
                'Imagen actual (se conserva si no eliges otra).';
            document.getElementById('btn_quitar_imagen').classList.toggle('d-none', !esNueva);
            wrap.classList.remove('d-none');
        }

        // Cuando eligen o toman una foto
        inputImagen.addEventListener('change', async () => {
            const file = inputImagen.files[0];
            if (!file) return;

            let final = file;

            // Solo comprimimos JPEG (fotos de cámara); los PNG se envían tal cual para no perder transparencia
            if (file.type === 'image/jpeg') {
                try {
                    final = await comprimirImagen(file);
                    if (final !== file) {
                        const dt = new DataTransfer();
                        dt.items.add(final);
                        inputImagen.files = dt.files;
                    }
                } catch (err) {
                    final = file; // si algo falla, se sube la original
                }
            }

            if (urlPreviewNueva) URL.revokeObjectURL(urlPreviewNueva);
            urlPreviewNueva = URL.createObjectURL(final);
            mostrarPreview(urlPreviewNueva, true);
        });

        // Quitar la foto recién elegida y volver a la imagen actual (si existe)
        function quitarImagenNueva() {
            inputImagen.value = '';
            if (urlPreviewNueva) {
                URL.revokeObjectURL(urlPreviewNueva);
                urlPreviewNueva = null;
            }
            mostrarPreview(imagenActualUrl, false);
        }

        // ---------- Switch "¿Es juego?" ----------
        document.getElementById('f_juego').addEventListener('change', function() {
            document.getElementById('es_juego_label').textContent = this.checked ? 'Sí' : 'No';
        });

        // Evita doble envío mientras sube la imagen
        document.getElementById('formBirlos').addEventListener('submit', () => {
            const btn = document.getElementById('btn_guardar');
            btn.disabled = true;
            btn.textContent = 'Guardando...';
        });

        // ---------- Clicks delegados (funcionan también en filas colapsadas por DataTables) ----------
        document.addEventListener('click', e => {
            // Editar
            const btnEditar = e.target.closest('.btn-editar');
            if (btnEditar) {
                abrirModal(JSON.parse(btnEditar.dataset.registro));
                return;
            }

            // Ver imagen en grande
            const img = e.target.closest('.img-zoom');
            if (img) {
                document.getElementById('imgGrande').src = img.dataset.src;
                document.getElementById('imgGrande').alt = img.dataset.titulo;
                document.getElementById('imgTitulo').innerText = img.dataset.titulo;
                document.getElementById('imgDetalle').innerText = img.dataset.detalle;
                document.getElementById('imgVenta').innerText = img.dataset.venta;

                bootstrap.Modal.getOrCreateInstance(document.getElementById('modalImagen')).show();
            }
        });

        // Confirmar eliminación (delegado)
        document.addEventListener('submit', e => {
            const form = e.target.closest('.form-eliminar');
            if (!form) return;

            e.preventDefault();

            Swal.fire({
                title: '¿Eliminar?',
                text: 'Se eliminará el registro y su imagen.',
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

        // ---------- Modal crear / editar ----------
        function abrirModal(r = null) {
            const form = document.getElementById('formBirlos');
            const editando = r !== null;

            form.reset();

            // Restablecer el botón Guardar y la imagen
            const btnGuardar = document.getElementById('btn_guardar');
            btnGuardar.disabled = false;
            btnGuardar.textContent = 'Guardar';

            if (urlPreviewNueva) {
                URL.revokeObjectURL(urlPreviewNueva);
                urlPreviewNueva = null;
            }

            form.action = editando ?
                "{{ url('/editar_birlo') }}" :
                "{{ url('/guardar_birlo') }}";

            document.getElementById('metodo').value = editando ? 'PUT' : 'POST';
            document.getElementById('birlo_id').value = editando ? r.id : '';
            document.getElementById('tituloModal').innerText = editando ? 'Editar birlos' : 'Nuevos birlos';

            // Switch "¿Es juego?" y su texto
            const juego = editando && Number(r.juego) === 1;
            document.getElementById('f_juego').checked = juego;
            document.getElementById('es_juego_label').textContent = juego ? 'Sí' : 'No';

            // Vista previa de la imagen actual
            imagenActualUrl = (editando && r.imagen) ? "{{ asset('storage') }}/" + r.imagen : null;
            mostrarPreview(imagenActualUrl, false);

            if (editando) {
                document.getElementById('f_cantidad').value = r.cantidad;
                document.getElementById('f_medida').value = r.medida;
                document.getElementById('f_tipo').value = r.tipo;
                document.getElementById('f_estilo').value = r.estilo;
                document.getElementById('f_compra').value = r.precio_compra;
                document.getElementById('f_venta').value = r.precio_venta;
            }

            bootstrap.Modal.getOrCreateInstance(document.getElementById('modalBirlos')).show();
        }
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
