@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between mt-3 mb-3">
            <h4>Birlos</h4>

            <button class="btn btn-primary" onclick="abrirModal()">
                + Nuevo
            </button>
        </div>

        {{-- Tabla --}}
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle tabla-rines">
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
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($birlos as $br)
                        <tr>
                            <td class="text-center">
                                @if ($br->imagen)
                                    <img src="{{ asset('storage/' . $br->imagen) }}" alt="Birlo" class="img-thumbnail"
                                        style="width:60px;height:60px;object-fit:cover;" loading="lazy">
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
                            <td>
                                <div class="btn-group" role="group" aria-label="Button group with nested dropdown">
                                    <div class="btn-group" role="group">
                                        <button type="button" class="btn btn-primary dropdown-toggle"
                                            data-bs-toggle="dropdown" aria-expanded="false">
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
                    @empty
                        <tr>
                            <td colspan="10" class="text-center text-muted">Sin registro</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
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

                    <div class="col-6">
                        <label for="f_juego" class="form-label">¿Es juego?</label>
                        <div class="form-check form-switch">
                            {{-- Para que se envíe "0" cuando el switch está apagado --}}
                            <input type="hidden" name="es_juego" value="0">
                            <input class="form-check-input" type="checkbox" role="switch" id="f_juego"
                                name="es_juego" value="1">
                            <label class="form-check-label" for="f_juego" id="es_juego_label">No</label>
                        </div>
                    </div>

                    <div class="col-6">
                        <label for="f_imagen" class="form-label">Imagen del producto</label>
                        <input class="form-control" type="file" id="f_imagen" name="imagen"
                            accept="image/png, image/jpeg, image/webp">

                        <div id="preview_imagen_wrap" class="mt-2 d-none">
                            <img id="preview_imagen" class="img-thumbnail"
                                style="width:80px;height:80px;object-fit:cover;" alt="Imagen actual">
                            <div class="form-text">Déjalo vacío para conservar esta imagen.</div>
                        </div>
                    </div>

                    <input type="hidden" value="Potreros" name="tienda" id="f_tienda">
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
        document.addEventListener('DOMContentLoaded', () => {
            // Texto Sí / No del switch "¿Es juego?"
            const toggle = document.getElementById('f_juego');
            const label = document.getElementById('es_juego_label');

            toggle.addEventListener('change', () => {
                label.textContent = toggle.checked ? 'Sí' : 'No';
            });

            // Botones "Editar"
            document.querySelectorAll('.btn-editar').forEach(btn => {
                btn.addEventListener('click', () => abrirModal(JSON.parse(btn.dataset.registro)));
            });
        });

        // Modal crear / editar
        function abrirModal(r = null) {
            const form = document.getElementById('formBirlos');
            const editando = r !== null;

            form.reset();

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
            const wrap = document.getElementById('preview_imagen_wrap');
            const preview = document.getElementById('preview_imagen');
            if (editando && r.imagen) {
                preview.src = "{{ asset('storage') }}/" + r.imagen;
                wrap.classList.remove('d-none');
            } else {
                preview.removeAttribute('src');
                wrap.classList.add('d-none');
            }

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

        confirmarEnvio('.form-eliminar', '¿Eliminar?', 'Se eliminará el registro y su imagen.');
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
