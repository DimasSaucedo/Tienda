@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="d-flex justify-content-between mt-3 mb-3">
            <h4>Precios de rines</h4>
            <button class="btn btn-primary" onclick="abrirModal()">+ Nuevo precio</button>
        </div>

        {{-- Filtros --}}
        {{-- <form method="GET" class="row g-2 mb-3">
            <div class="col-md-2">
                <select name="rin" class="form-select">
                    <option value="">Rin (todos)</option>
                    @foreach (range(10, 32) as $r)
                        <option value="{{ $r }}" @selected(request('rin') == $r)>{{ $r }}"</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <select name="ancho" class="form-select">
                    <option value="">Ancho (todos)</option>
                    @foreach (range(5, 15, 0.25) as $a)
                        <option value="{{ $a }}" @selected(request('ancho') == $a)>{{ $a }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-outline-secondary w-100">Filtrar</button>
            </div>
        </form> --}}

        {{-- Tabla --}}
        <div class="table-responsive">
            <table class="table table-striped table-hover align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>Medida</th>
                        <th>Barrenación</th>
                        <th>Tipo</th>
                        {{-- <th>Tienda</th> --}}
                        <th class="text-end">Compra</th>
                        <th class="text-end">Venta</th>
                        <th class="text-end">Ganancia</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($rines as $r)
                        <tr>
                            <td>{{ $r->rin }}'' x {{ $r->ancho }}</td>
                            <td>{{ $r->barrenacion }}</td>
                            <td>{{ $r->tipo }}</td>
                            {{-- <td>{{ $r->tienda }}</td> --}}
                            <td class="text-end">${{ number_format($r->precioCompra, 2) }}</td>
                            <td class="text-end">${{ number_format($r->precioVenta, 2) }}</td>
                            <td class="text-end text-success">${{ number_format($r->precioVenta - $r->precioCompra, 2) }}
                            </td>
                            <td class="text-end text-nowrap">
                                <button class="btn btn-sm btn-warning"
                                    onclick='abrirModal(@json($r))'>Editar</button>

                                <form action="{{ route('precio_rines.destroy', $r->id) }}" method="POST"
                                    class="d-inline form-eliminar">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger">Eliminar</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="text-center text-muted">Sin registros</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Modal crear/editar --}}
    <div class="modal fade" id="modalPrecio" tabindex="-1">
        <div class="modal-dialog">
            <form method="POST" id="formPrecio" class="modal-content">
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
                                <option value="{{ $r }}">{{ $r }}"</option>
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
                        <label class="form-label">Barrenacion</label>
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
                    {{-- <div class="col-12">
                        <label class="form-label">Tienda</label>
                        <input type="text" name="tienda" id="f_tienda" class="form-control">
                    </div> --}}
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
                </div>

                <div class="modal-footer">
                    <button class="btn btn-primary">Guardar</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function abrirModal(r = null) {
            const form = document.getElementById('formPrecio');

            if (r) {
                form.action = "{{ url('precio-rines') }}/" + r.id;
                document.getElementById('metodo').value = 'PUT';
                document.getElementById('tituloModal').innerText = 'Editar precio';

                f_rin.value = r.rin;
                f_ancho.value = parseFloat(r.ancho);
                f_barrenacion.value = r.barrenacion ?? '';
                f_tipo.value = r.tipo ?? 'Carro';
                f_compra.value = r.precioCompra;
                f_venta.value = r.precioVenta;
            } else {
                form.action = "{{ route('precio_rines.store') }}";
                document.getElementById('metodo').value = 'POST';
                document.getElementById('tituloModal').innerText = 'Nuevo precio';
                form.reset();
            }

            bootstrap.Modal.getOrCreateInstance(document.getElementById('modalPrecio')).show();
        }
    </script>

    {{-- Confirmación al eliminar --}}
    <script>
        document.querySelectorAll('.form-eliminar').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();

                Swal.fire({
                    title: '¿Eliminar este precio?',
                    text: 'Dejará de mostrarse en la lista.',
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
