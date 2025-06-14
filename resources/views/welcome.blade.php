@extends('layouts.app')
@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
        }

        .logo-space {
            text-align: center;
            padding: 2rem;
            background-color: #f8f9fa;
        }

        .logo-space img {
            max-width: 200px;
        }

        .section-title {
            color: #e9183b;
        }

        footer {
            background-color: #343a40;
            color: #fff;
            padding: 1.5rem;
            text-align: center;
        }

        .carousel-item {
            transition: transform 1s ease, opacity 1s ease;
        }


        /* Evitar que las imágenes se corten */
        .carousel-item img {
            width: 100%;
            height: auto;
            /* Mantener la proporción original */
            object-fit: contain;
            /* Asegurarse de que la imagen se ajuste sin distorsionarse */
        }

        .feature-box {
            transition: transform 0.3s;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            border-radius: 1rem;
        }

        .feature-box:hover {
            transform: translateY(-10px);
        }

        .feature-box img {
            width: 250px;
            height: auto;
        }

        #carouselRines {
            background: linear-gradient(to bottom, #e9183b 10%, white 90%);
        }

        /* Aplicando la tipografía solo a la sección específica */
        .rines,
        .marcas {
            font-family: 'Rubik', sans-serif;
        }
    </style>

    <!-- Carrusel de imágenes -->
    <div id="carouselRines" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="/images/carrusel/fondo_1.webp" class="d-block w-100" alt="Rin 1">
            </div>
            <div class="carousel-item">
                <img src="/images/carrusel/fondo_2.webp" loading="lazy" class="d-block w-100" alt="Llanta 1">
            </div>
            <div class="carousel-item">
                <img src="/images/carrusel/fondo_3.webp" loading="lazy" class="d-block w-100" alt="Showroom">
            </div>
            <div class="carousel-item">
                <img src="/images/carrusel/fondo_4.webp" loading="lazy" class="d-block w-100" alt="Showroom">
            </div>
            <div class="carousel-item">
                <img src="/images/carrusel/fondo_5.webp" loading="lazy" class="d-block w-100" alt="Showroom">
            </div>
            <div class="carousel-item">
                <img src="/images/carrusel/fondo_6.webp" loading="lazy" class="d-block w-100" alt="Showroom">
            </div>
            <div class="carousel-item">
                <img src="/images/carrusel/fondo_7.webp" loading="lazy" class="d-block w-100" alt="Showroom">
            </div>
            <div class="carousel-item">
                <img src="/images/carrusel/fondo_8.webp" loading="lazy" class="d-block w-100" alt="Showroom">
            </div>
            <div class="carousel-item">
                <img src="/images/carrusel/fondo_9.webp" loading="lazy" class="d-block w-100" alt="Showroom">
            </div>
            <div class="carousel-item">
                <img src="/images/carrusel/fondo_10.webp" loading="lazy" class="d-block w-100" alt="Showroom">
            </div>
            <div class="carousel-item">
                <img src="/images/carrusel/fondo_11.webp" loading="lazy" class="d-block w-100" alt="Showroom">
            </div>
            <div class="carousel-item">
                <img src="/images/carrusel/fondo_12.webp" loading="lazy" class="d-block w-100" alt="Showroom">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselRines" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselRines" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    <!-- Sección de características -->
    <!-- Sección de características -->
    <section class="py-5 container rines">
        <h2 class="text-center section-title mb-5" data-aos="fade-up">Lo mejor en rines y llantas</h2>
        <div class="row justify-content-center g-4">
            <div class="col-md-5" data-aos="fade-up" data-aos-delay="100">
                <div class="p-4 border rounded feature-box text-center">
                    <img src="/images/carrusel/rin_corvette.webp" alt="Rin de auto">
                    <h5 class="mt-3">Rines para auto</h5>
                    <p>Estilos deportivos y elegantes para que tu vehículo destaque en cada camino.</p>
                </div>
            </div>
            <div class="col-md-5" data-aos="fade-up" data-aos-delay="200">
                <div class="p-4 border rounded feature-box text-center">
                    <img src="/images/carrusel/rin_troca.webp" alt="Rin de troca">
                    <h5 class="mt-3">Rines para troca</h5>
                    <p>Resistencia y presencia en cada rodada, ideales para trabajo y aventura.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-5 bg-light text-center marcas" data-aos="fade-up">
        <h3 class="section-title mb-4">Trabajamos con las mejores marcas</h3>
        <div class="d-flex flex-wrap justify-content-center gap-4">
            <img src="/images/marcas/american.webp" alt="BFGoodrich" style="height: 100px;" data-aos="zoom-in" data-aos-delay="100">
            <img src="/images/marcas/msmotor.webp" alt="Michelin" style="height: 100px;" data-aos="zoom-in" data-aos-delay="200">
            <img src="/images/marcas/saxorines.webp" alt="" style="height: 100px;" data-aos="zoom-in" data-aos-delay="300">
            <img src="/images/marcas/ilink.webp" alt="" style="height: 50px;" data-aos="zoom-in" data-aos-delay="400">
            <img src="/images/marcas/mirage.webp" alt="" style="height: 50px;" data-aos="zoom-in" data-aos-delay="500">
            <img src="/images/marcas/roadclaw.webp" alt="" style="height: 50px;" data-aos="zoom-in" data-aos-delay="600">
            <img src="/images/marcas/winrun.webp" alt="" style="height: 50px;" data-aos="zoom-in" data-aos-delay="700">
        </div>
    </section>



    <!-- Scripts -->
    {{--
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        AOS.init({
            once: false
        });
    </script>
@endsection