@extends('layouts.app')
@section('content')
    <style>
        .rin-imagen {
            transition: opacity 1s ease-in-out;
        }
    </style>
    <div class="container mb-5 p-3"
        style="background-color: rgb(224, 224, 224); box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2); min-height: 50px;">
        <div class="row justify-content-center align-items-center">
            <div class="col-md-12 col-12 d-flex flex-wrap justify-content-between align-items-center">
                <!-- Formulario -->
                <form action="/buscar_rines" class="d-flex flex-wrap w-100 justify-content-between" method="POST">
                    @csrf
                    <!-- Selección de Diámetro -->
                    <div class="col-md-3 col-12 mb-2 d-flex justify-content-center align-items-center">
                        <select name="diametro" id="diametro" class="form-control w-100">
                            <option value="" selected disabled>Diámetro</option>
                            <option value="13" @if (request('diametro') == '13') selected @endif>13</option>
                            <option value="14" @if (request('diametro') == '14') selected @endif>14</option>
                            <option value="15" @if (request('diametro') == '15') selected @endif>15</option>
                            <option value="16" @if (request('diametro') == '16') selected @endif>16</option>
                            <option value="17" @if (request('diametro') == '17') selected @endif>17</option>
                            <option value="18" @if (request('diametro') == '18') selected @endif>18</option>
                            <option value="19" @if (request('diametro') == '19') selected @endif>19</option>
                            <option value="20" @if (request('diametro') == '20') selected @endif>20</option>
                            <option value="21" @if (request('diametro') == '21') selected @endif>21</option>
                            <option value="22" @if (request('diametro') == '22') selected @endif>22</option>
                            <option value="24" @if (request('diametro') == '24') selected @endif>24</option>
                            <option value="26" @if (request('diametro') == '26') selected @endif>26</option>
                        </select>
                    </div>

                    <!-- Selección de Barrenaciones -->
                    <div class="col-md-3 col-12 mb-2 d-flex justify-content-center align-items-center">
                        <select name="barrenaciones" id="barrenaciones" class="form-control w-100">
                            <option value="" disabled selected>Barrenación</option>
                            <option value="4x100" @if (request('barrenaciones') == '4x100') selected @endif>4x100</option>
                            <option value="4x108" @if (request('barrenaciones') == '4x108') selected @endif>4x108</option>
                            <option value="4x114" @if (request('barrenaciones') == '4x114') selected @endif>4x114</option>
                            <option value="4x114 / 4x108" @if (request('barrenaciones') == '4x114 / 4x108') selected @endif>4x114 / 4x108
                            </option>
                            <option value="4x100 / 4x108" @if (request('barrenaciones') == '4x100 / 4x108') selected @endif>4x100 / 4x108
                            </option>
                            <option value="4x114 / 4x100" @if (request('barrenaciones') == '4x114 / 4x100') selected @endif>4x114 / 4x100
                            </option>
                            <option value="4x130" @if (request('barrenaciones') == '4x130') selected @endif>4x130</option>
                            <option value="5x100" @if (request('barrenaciones') == '5x100') selected @endif>5x100</option>
                            <option value="5x108" @if (request('barrenaciones') == '5x108') selected @endif>5x108</option>
                            <option value="5x110" @if (request('barrenaciones') == '5x110') selected @endif>5x110</option>
                            <option value="5x112" @if (request('barrenaciones') == '5x112') selected @endif>5x112</option>
                            <option value="5x113" @if (request('barrenaciones') == '5x113') selected @endif>5x113</option>
                            <option value="5x114" @if (request('barrenaciones') == '5x114') selected @endif>5x114</option>
                            <option value="5x114 / 5x100" @if (request('barrenaciones') == '5x114 / 5x100') selected @endif>5x114 / 5x100
                            </option>
                            <option value="5x100 / 5x108" @if (request('barrenaciones') == '5x100 / 5x108') selected @endif>5x100 / 5x108
                            </option>
                            <option value="5x112 / 5x100" @if (request('barrenaciones') == '5x112 / 5x100') selected @endif>5x112 / 5x100
                            </option>
                            <option value="5x120" @if (request('barrenaciones') == '5x120') selected @endif>5x120</option>
                            <option value="5x127" @if (request('barrenaciones') == '5x127') selected @endif>5x127</option>
                            <option value="5x127 / 5x120" @if (request('barrenaciones') == '5x127 / 5x120') selected @endif>5x127 / 5x120
                            </option>
                            <option value="5x127 / 5x135" @if (request('barrenaciones') == '5x127 / 5x135') selected @endif>5x127 / 5x135
                            </option>
                            <option value="5x127 / 5x139" @if (request('barrenaciones') == '5x127 / 5x139') selected @endif>5x127 / 5x139
                            </option>
                            <option value="5x135 / 5x139" @if (request('barrenaciones') == '5x135 / 5x139') selected @endif>5x135 / 5x139
                            </option>
                            <option value="5x135" @if (request('barrenaciones') == '5x135') selected @endif>5x135</option>
                            <option value="5x139" @if (request('barrenaciones') == '5x139') selected @endif>5x139</option>
                            <option value="5x150" @if (request('barrenaciones') == '5x150') selected @endif>5x150</option>
                            <option value="6x114" @if (request('barrenaciones') == '6x114') selected @endif>6x114</option>
                            <option value="6x120" @if (request('barrenaciones') == '6x120') selected @endif>6x120</option>
                            <option value="6x130" @if (request('barrenaciones') == '6x130') selected @endif>6x130</option>
                            <option value="6x135" @if (request('barrenaciones') == '6x135') selected @endif>6x135</option>
                            <option value="6x139" @if (request('barrenaciones') == '6x139') selected @endif>6x139</option>
                            <option value="6x139 / 6x135" @if (request('barrenaciones') == '6x139 / 6x135') selected @endif>6x139 / 6x135
                            </option>
                            <option value="8x170" @if (request('barrenaciones') == '8x170') selected @endif>8x170</option>
                            <option value="8x170 / 8x180" @if (request('barrenaciones') == '8x170 / 8x180') selected @endif>8x170 / 8x180
                            </option>
                        </select>
                    </div>

                    <!-- Botón Buscar Rines -->
                    <div class="col-md-2 col-12 d-flex justify-content-center align-items-center">
                        <button class="btn btn-primary w-100" type="submit"><i class="fa-solid fa-magnifying-glass"></i>
                            Buscar rines</button>
                    </div>
                    <div class="col-md-2 col-12 d-flex justify-content-center align-items-center mt-2 mt-md-0">
                        <a href="/rines" class="btn btn-secondary w-100"><i class="fa-solid fa-list"></i> Ver Todos</a>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="container mt-5">
        <!-- Botón Agregar Rin (solo visible para usuarios autenticados) -->
        @auth
            <div class="col-md-12 col-12 d-flex justify-content-center align-items-center mt-2 mt-md-0">
                <button class="btn btn-success w-100" type="button" data-bs-toggle="modal"
                    data-bs-target="#modal-agregar-rin"><i class="fa-solid fa-plus"></i> Agregar Rin</button>
            </div>
            @include('Rines.agregar_rin')
        @endauth
        <div class="row row-cols-1 row-cols-md-4 g-4">
            @foreach ($rines as $item)
                <div class="col">
                    <div class="card d-flex flex-column"
                        style="width: 100%; height: 325px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.2);">
                        <img src="/images/rines/{{ $item->foto_principal }}"
                            @if ($item->foto_secundaria) data-secundaria="/images/rines/{{ $item->foto_secundaria }}"
                            data-secondary="/images/rines/{{ $item->foto_secundaria }}" @endif
                            data-bs-toggle="modal" data-bs-target="#imageModal"
                            class="card-img-top mx-auto d-block rin-imagen mt-2"
                            data-primary="/images/rines/{{ $item->foto_principal }}" alt="Imagen principal"
                            data-diametro-ancho="{{ $item->diametro_ancho }}"
                            style="max-width: 175px; transition: 3s ease; overflow: hidden;">
                        <div class="card-body d-flex flex-column mt-auto">
                            <div class="mt-auto">
                                <h4 class="card-title text-center">{{ $item->diametro_ancho }}</h4>
                                <h6 class="text-center">{{ $item->barrenacion }}</h6>
                            </div>
                            @auth
                                <div class="text-center mt-auto mb-2">
                                    <button class="btn btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#modal-actualizar-{{ $item->id }}"><i
                                            class="fa-solid fa-pen-to-square"></i> Editar</button>
                                    <button class="btn btn-danger btn-eliminar" data-id="{{ $item->id }}"><i
                                            class="fa-solid fa-trash"></i> Eliminar</button>
                                </div>
                            @endauth
                        </div>
                    </div>
                </div>
                @include('Rines.editar_rin')
            @endforeach
        </div>

        <!-- Paginación -->
        <nav aria-label="Page navigation example" class="mt-5">
            <ul class="pagination justify-content-center">
                {{ $rines->links('pagination::bootstrap-4') }}
            </ul>
        </nav>

    </div>

    <!-- Modal de imagen con carrusel -->
    <div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="imageModalLabel">Imagen del Rin</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <!-- Carrusel de imágenes -->
                    <div id="carouselExampleIndicators" class="carousel slide">
                        <div class="carousel-inner">
                            <div class="carousel-item active text-center">
                                <!-- Centrar la imagen grande -->
                                <img id="modalPrimaryImage" src="" class="d-block mx-auto"
                                    style="max-width: 400px;" alt="Imagen principal">
                            </div>
                            <div class="carousel-item text-center">
                                <img id="modalSecondaryImage" src="" class="d-block mx-auto"
                                    style="max-width: 400px;" alt="Imagen secundaria">
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Anterior</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Siguiente</span>
                        </button>
                    </div>
                    <!-- Miniaturas -->
                    <div class="text-center mt-3">
                        <img id="thumbnailPrimary" src="" alt="Imagen primaria"
                            style="width: 70px; cursor: pointer;">
                        <img id="thumbnailSecondary" src="" alt="Imagen secundaria"
                            style="width: 70px; cursor: pointer;">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.rin-imagen').hover(
                function() {
                    // Cambiar a la imagen secundaria al pasar el mouse, si existe
                    const secondarySrc = $(this).data('secundaria');
                    if (secondarySrc) {
                        $(this).data('original', $(this).attr('src')); // Guardar la imagen original
                        $(this).stop(true, true).fadeTo(150, 0); // Desvanecer la imagen en 150ms
                        setTimeout(() => {
                            $(this).attr('src', secondarySrc); // Cambiar la imagen después de 150ms
                            $(this).fadeTo(150,
                                1); // Restaurar la visibilidad con una transición de 150ms
                        }, 200); // Tiempo de espera antes de cambiar la imagen
                    }
                },
                function() {
                    // Cambiar de vuelta a la imagen original al quitar el mouse
                    const originalSrc = $(this).data('original');
                    if (originalSrc) {
                        $(this).stop(true, true).fadeTo(150, 0); // Desvanecer la imagen en 150ms
                        setTimeout(() => {
                            $(this).attr('src',
                                originalSrc); // Cambiar a la imagen original después de 150ms
                            $(this).fadeTo(150,
                                1); // Restaurar la visibilidad con una transición de 150ms
                        }, 200); // Tiempo de espera antes de cambiar la imagen
                    }
                }
            );

            // Al hacer clic en una imagen de rin
            $('.rin-imagen').on('click', function() {
                const primaryImage = $(this).data('primary');
                const secondaryImage = $(this).data('secondary');
                const diametroAncho = $(this).data('diametro-ancho');

                $('#imageModalLabel').text(diametroAncho);

                // Asignar la imagen principal al carrusel
                $('#modalPrimaryImage').attr('src', primaryImage);

                // Solo asignar la imagen secundaria si existe
                if (secondaryImage) {
                    $('#modalSecondaryImage').attr('src', secondaryImage);
                    $('#thumbnailSecondary').attr('src', secondaryImage).show();
                    $('.carousel-control-prev, .carousel-control-next').show(); // Mostrar controles
                } else {
                    $('#modalSecondaryImage').attr('src', ''); // Quitar imagen secundaria
                    $('#thumbnailSecondary').hide(); // Ocultar la miniatura secundaria si no hay imagen
                    $('.carousel-control-prev, .carousel-control-next').hide();
                }

                // Asignar siempre la miniatura principal
                $('#thumbnailPrimary').attr('src', primaryImage);
            });

            // Al hacer clic en la miniatura de la imagen primaria
            $('#thumbnailPrimary').on('click', function() {
                const primaryImage = $(this).attr('src');
                const secondaryImage = $('#thumbnailSecondary').attr('src');

                // Cambiar las imágenes en el carrusel
                $('#modalPrimaryImage').attr('src', primaryImage);
                $('#modalSecondaryImage').attr('src', secondaryImage);
            });

            // Al hacer clic en la miniatura de la imagen secundaria
            $('#thumbnailSecondary').on('click', function() {
                const secondaryImage = $(this).attr('src');
                const primaryImage = $('#thumbnailPrimary').attr('src');

                // Cambiar las imágenes en el carrusel
                $('#modalPrimaryImage').attr('src', secondaryImage);
                $('#modalSecondaryImage').attr('src', primaryImage);
            });


            $('.btn-eliminar').click(function() {
                const rinId = $(this).data('id'); // Obtener el ID desde el atributo data-id
                // Confirmación de SweetAlert
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "No podrás revertir esto",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Sí, eliminar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '/eliminar_rin', // URL del endpoint al que haces la solicitud
                            type: 'POST', // Tipo de solicitud (GET, POST, PUT, DELETE, etc.)
                            data: {
                                // Datos a enviar en la solicitud
                                id: rinId
                            },
                            success: function(response) {
                                // Código a ejecutar si la solicitud es exitosa
                                Swal.close();

                                Swal.fire({
                                    icon: 'success',
                                    title: 'Éxito',
                                    text: response.message ||
                                        'Operación exitosa',
                                    confirmButtonText: 'Aceptar'
                                }).then(() => {
                                    //actualizarTabla(response.gastos);
                                    window.location.reload();
                                });
                            },
                            error: function(xhr, status, error) {
                                Swal.close();

                                // Mostrar mensaje de error
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Error',
                                    text: xhr.responseJSON
                                        .message ||
                                        'Error en la solicitud',
                                    confirmButtonText: 'Aceptar'
                                });
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection
