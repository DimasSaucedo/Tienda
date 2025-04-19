@extends('layouts.app')
@section('content')
    <style>
        .hero-section {
            height: 100vh;
            background-color: #e9183b;
            display: flex;
            justify-content: center;
            align-items: center;
            flex-direction: column;
            transition: background-color 1s ease;
        }

        /* .hero-section h1 {
                                                            font-size: 4rem;
                                                            color: white;
                                                            animation: zoomIn 2s ease;
                                                            margin-top: -200px;
                                                            /* Ajusta este valor para mover el texto más arriba */
        /* Otra opción: */
        /* position: relative;
                                                               top: -100px;
                                                        } */

        .wheel {
            height: 280px;
            animation: riseAndGrow 2.5s ease forwards;
            transition: transform 0.8s ease-out;
            transform-origin: center;
        }

        @keyframes riseAndGrow {
            0% {
                transform: translateY(100%) scale(0.2);
                opacity: 0;
            }

            100% {
                transform: translateY(-10%) scale(2);
                opacity: 1;
            }
        }

        .wheel.shrink {
            animation: growAndRise 1.5s ease forwards;
            /* Evita que riseAndGrow se repita */
            transform: translateY(0) scale(1);
        }

        @keyframes growAndRise {
            0% {
                transform: translateY(-10%) scale(2);
                opacity: 1;
            }

            100% {
                transform: translateY(100%) scale(0.2);
                opacity: 0;
            }
        }

        @keyframes zoomIn {
            0% {
                transform: scale(0.5);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes scaleUp {
            0% {
                transform: scale(0.5);
                opacity: 0;
            }

            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        .carousel-section {
            opacity: 0;
            transform: scale(0.5);
            transition: transform 0.8s ease-out, opacity 0.8s ease-out;
        }
    </style>

    <!-- Hero Section -->
    <section class="hero-section">
        {{-- <h1>Rines Saucedo</h1> --}}
        <img src="/images/carrusel/combin.png" alt="Rin Saucedo" class="wheel">
    </section>

    <!-- Carrusel Section -->
    <section class="carousel-section">
        <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="/images/carrusel/fondo_1.jpeg" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="/images/carrusel/fondo_2.png" class="d-block w-100" alt="...">
                </div>
                <div class="carousel-item">
                    <img src="/images/carrusel/fondo_3.png" class="d-bl ock w-100" alt="...">
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
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
    </section>

    <script>
        window.addEventListener('scroll', () => {
            const heroSection = document.querySelector('.hero-section');
            const carouselSection = document.querySelector('.carousel-section');
            const wheelImage = document.querySelector('.wheel');
            const scrollPosition = window.scrollY;

            if (scrollPosition > heroSection.offsetHeight / 2) {
                heroSection.style.backgroundColor = 'white';
                carouselSection.style.opacity = '1';
                carouselSection.style.transform = 'scale(1)';
                wheelImage.classList.add('shrink'); // Reduce la imagen al hacer scroll
            } else {
                heroSection.style.backgroundColor = '#e9183b';
                carouselSection.style.opacity = '0';
                carouselSection.style.transform = 'scale(0.5)';
                wheelImage.classList.remove('shrink'); // Restaura la imagen al volver a la sección
            }
        });
    </script>
@endsection
