@extends('layouts.app')

@section('content')
    <style>
        .carousel {
            max-height: 88vh;
            /* Ajusta según lo que necesites */
            overflow: hidden;
            /* Ocultar cualquier contenido que se salga */
            border-radius: 20px;
        }

        @media (max-width: 768px) {
            .carousel {
                max-height: 60vh;
                /* Reduce la altura en móviles */
            }

            .carousel-item img {
                height: auto;
                /* Ajuste de altura automática */
                object-fit: cover;
                /* Asegura que las imágenes mantengan su proporción */
            }
        }
    </style>
    
    <div class="container mt-2 mb-2">
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel" data-bs-interval="3000"
            data-bs-pause="false">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"
                    aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"
                    aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2"
                    aria-label="Slide 3"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="3"
                    aria-label="Slide 4"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="4"
                    aria-label="Slide 5"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="5"
                    aria-label="Slide 6"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="6"
                    aria-label="Slide 7"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="7"
                    aria-label="Slide 8"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="8"
                    aria-label="Slide 9"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="9"
                    aria-label="Slide 10"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="10"
                    aria-label="Slide 11"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="11"
                    aria-label="Slide 12"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="12"
                    aria-label="Slide 13"></button>
            </div>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="/images/carrusel/fondo_1.jpeg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="/images/carrusel/fondo_2.png" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="/images/carrusel/fondo_3.png" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="/images/carrusel/fondo_4.png" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="/images/carrusel/fondo_5.png" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="/images/carrusel/fondo_6.png" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="/images/carrusel/fondo_7.png" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="/images/carrusel/fondo_8.png" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="/images/carrusel/fondo_9.png" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="/images/carrusel/fondo_10.png" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="/images/carrusel/fondo_11.png" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="/images/carrusel/fondo_12.png" class="d-block w-100" alt="...">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators"
                data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </div>
@endsection
