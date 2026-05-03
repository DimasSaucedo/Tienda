@extends('layouts.app')
@section('content')
    <link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Rubik:wght@400;500;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
        }

        .section-title {
            color: #e9183b;
        }

        .carousel-item {
            transition: transform 1s ease, opacity 1s ease;
        }

        .carousel-item img {
            width: 100%;
            height: 520px;
            object-fit: cover;
        }

        .hero-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.45);
            z-index: 10;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 1rem;
        }

        .hero-overlay h1 {
            font-size: 3rem;
            font-weight: 700;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.8);
            color: white;
        }

        .hero-overlay p {
            font-size: 1.3rem;
            text-shadow: 1px 1px 4px rgba(0, 0, 0, 0.8);
            color: white;
        }

        @media (max-width: 768px) {
            .carousel-item img {
                height: 280px;
            }

            .hero-overlay h1 {
                font-size: 1.8rem;
            }

            .hero-overlay p {
                font-size: 1rem;
            }
        }

        .stats-section {
            background: #e9183b;
            color: white;
        }

        .stats-section h2 {
            font-size: 2.8rem;
            font-weight: 700;
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

        .sucursal-card {
            border: none;
            border-radius: 1rem;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            transition: transform 0.3s;
        }

        .sucursal-card:hover {
            transform: translateY(-5px);
        }

        .sucursal-icon {
            width: 50px;
            height: 50px;
            background: #e9183b;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .whatsapp-btn {
            position: fixed;
            bottom: 25px;
            right: 25px;
            z-index: 999;
            background: #25D366;
            color: white;
            border-radius: 50px;
            padding: 12px 20px;
            font-weight: bold;
            text-decoration: none;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.3);
            display: flex;
            align-items: center;
            gap: 8px;
            transition: transform 0.2s, box-shadow 0.2s;
        }

        .whatsapp-btn:hover {
            transform: scale(1.05);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.35);
            color: white;
        }

        .rines,
        .marcas {
            font-family: 'Rubik', sans-serif;
        }

        footer {
            background-color: #343a40;
            color: #fff;
            padding: 1.5rem;
            text-align: center;
        }
    </style>

    {{-- ===================== HERO / CARRUSEL ===================== --}}
    <div id="carouselRines" class="carousel slide position-relative" data-bs-ride="carousel">

        <div class="hero-overlay">
            <h1 class="fw-bold">Tu estilo, sobre ruedas</h1>
            <p class="lead mb-4">Rines, llantas y baterías para todo tipo de vehículo</p>
            <a href="#caracteristicas" class="btn btn-danger btn-lg px-5 py-3 fw-bold">
                Ver productos
            </a>
        </div>

        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="/images/carrusel/fondo_1.webp" alt="Rin 1">
            </div>
            <div class="carousel-item">
                <img src="/images/carrusel/fondo_2.webp" loading="lazy" alt="Llanta 1">
            </div>
            <div class="carousel-item">
                <img src="/images/carrusel/fondo_3.webp" loading="lazy" alt="Showroom">
            </div>
            <div class="carousel-item">
                <img src="/images/carrusel/fondo_4.webp" loading="lazy" alt="Showroom">
            </div>
            <div class="carousel-item">
                <img src="/images/carrusel/fondo_5.webp" loading="lazy" alt="Showroom">
            </div>
            <div class="carousel-item">
                <img src="/images/carrusel/fondo_6.webp" loading="lazy" alt="Showroom">
            </div>
            <div class="carousel-item">
                <img src="/images/carrusel/fondo_7.webp" loading="lazy" alt="Showroom">
            </div>
            <div class="carousel-item">
                <img src="/images/carrusel/fondo_8.webp" loading="lazy" alt="Showroom">
            </div>
            <div class="carousel-item">
                <img src="/images/carrusel/fondo_9.webp" loading="lazy" alt="Showroom">
            </div>
            <div class="carousel-item">
                <img src="/images/carrusel/fondo_10.webp" loading="lazy" alt="Showroom">
            </div>
            <div class="carousel-item">
                <img src="/images/carrusel/fondo_11.webp" loading="lazy" alt="Showroom">
            </div>
            <div class="carousel-item">
                <img src="/images/carrusel/fondo_12.webp" loading="lazy" alt="Showroom">
            </div>
        </div>

        <button class="carousel-control-prev" type="button" data-bs-target="#carouselRines" data-bs-slide="prev">
            <span class="carousel-control-prev-icon"></span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselRines" data-bs-slide="next">
            <span class="carousel-control-next-icon"></span>
        </button>
    </div>

    {{-- ===================== ESTADÍSTICAS ===================== --}}
    <section class="stats-section py-4">
        <div class="container">
            <div class="row text-center">
                <div class="col-6 col-md-3 py-3">
                    <h2 class="counter" data-target="500">0</h2>
                    <p class="mb-0 fw-semibold">Modelos de rines</p>
                </div>
                <div class="col-6 col-md-3 py-3">
                    <h2 class="counter" data-target="15">0</h2>
                    <p class="mb-0 fw-semibold">Años de experiencia</p>
                </div>
                <div class="col-6 col-md-3 py-3">
                    <h2 class="counter" data-target="2000">0</h2>
                    <p class="mb-0 fw-semibold">Clientes satisfechos</p>
                </div>
                <div class="col-6 col-md-3 py-3">
                    <h2 class="counter" data-target="2">0</h2>
                    <p class="mb-0 fw-semibold">Sucursales</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== CARACTERÍSTICAS ===================== --}}
    <section class="py-5 container rines" id="caracteristicas">
        <h2 class="text-center section-title mb-5" data-aos="fade-up">Lo mejor en rines y llantas</h2>
        <div class="row justify-content-center g-4">
            <div class="col-md-5" data-aos="fade-up" data-aos-delay="100">
                <div class="p-4 border rounded feature-box text-center bg-white">
                    <img src="/images/carrusel/rin_corvette.webp" alt="Rin de auto">
                    <h5 class="mt-3">Rines para auto</h5>
                    <p>Estilos deportivos y elegantes para que tu vehículo destaque en cada camino.</p>
                </div>
            </div>
            <div class="col-md-5" data-aos="fade-up" data-aos-delay="200">
                <div class="p-4 border rounded feature-box text-center bg-white">
                    <img src="/images/carrusel/rin_troca.webp" alt="Rin de troca">
                    <h5 class="mt-3">Rines para troca</h5>
                    <p>Resistencia y presencia en cada rodada, ideales para trabajo y aventura.</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ===================== MARCAS ===================== --}}
    <section class="py-5 bg-light text-center marcas" data-aos="fade-up">
        <h3 class="section-title mb-4">Trabajamos con las mejores marcas</h3>
        <div class="d-flex flex-wrap justify-content-center gap-4 align-items-center">
            <img src="/images/marcas/american.webp" alt="American" style="height:100px;" data-aos="zoom-in"
                data-aos-delay="100">
            <img src="/images/marcas/msmotor.webp" alt="MS Motor" style="height:100px;" data-aos="zoom-in"
                data-aos-delay="200">
            <img src="/images/marcas/saxorines.webp" alt="Saxo Rines" style="height:100px;" data-aos="zoom-in"
                data-aos-delay="300">
            <img src="/images/marcas/ilink.webp" alt="iLink" style="height:50px;" data-aos="zoom-in"
                data-aos-delay="400">
            <img src="/images/marcas/mirage.webp" alt="Mirage" style="height:50px;" data-aos="zoom-in"
                data-aos-delay="500">
            <img src="/images/marcas/roadclaw.webp" alt="Roadclaw" style="height:50px;" data-aos="zoom-in"
                data-aos-delay="600">
            <img src="/images/marcas/winrun.webp" alt="Winrun" style="height:50px;" data-aos="zoom-in"
                data-aos-delay="700">
        </div>
    </section>

    {{-- ===================== SUCURSALES ===================== --}}
    <section class="py-5 container" data-aos="fade-up">
        <h3 class="text-center section-title mb-5">¿Dónde encontrarnos?</h3>
        <div class="row g-4">

            <div class="col-md-6" data-aos="fade-right">
                <div class="card sucursal-card p-4 h-100">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="sucursal-icon">
                            <i class="fa-solid fa-location-dot text-white fs-5"></i>
                        </div>
                        <h5 class="mb-0">Sucursal Potreros</h5>
                    </div>
                    <p class="text-muted mb-2">
                        <i class="fa-regular fa-clock me-2 text-danger"></i>Lun - Sáb: 9:00am - 7:00pm
                    </p>
                    <p class="text-muted mb-2">
                        <i class="fa-solid fa-phone me-2 text-danger"></i>449 000 0000
                    </p>
                    <p class="text-muted mb-3">
                        <i class="fa-solid fa-map-pin me-2 text-danger"></i>Tu dirección aquí, Aguascalientes
                    </p>
                    <a href="https://maps.google.com/?q=TU_DIRECCION_POTREROS" target="_blank"
                        class="btn btn-outline-danger mt-auto">
                        <i class="fa-solid fa-map me-2"></i>Ver en Google Maps
                    </a>
                </div>
            </div>

            <div class="col-md-6" data-aos="fade-left">
                <div class="card sucursal-card p-4 h-100">
                    <div class="d-flex align-items-center gap-3 mb-3">
                        <div class="sucursal-icon">
                            <i class="fa-solid fa-location-dot text-white fs-5"></i>
                        </div>
                        <h5 class="mb-0">Sucursal Guadalupano</h5>
                    </div>
                    <p class="text-muted mb-2">
                        <i class="fa-regular fa-clock me-2 text-danger"></i>Lun - Sáb: 9:00am - 7:00pm
                    </p>
                    <p class="text-muted mb-2">
                        <i class="fa-solid fa-phone me-2 text-danger"></i>449 000 0000
                    </p>
                    <p class="text-muted mb-3">
                        <i class="fa-solid fa-map-pin me-2 text-danger"></i>Tu dirección aquí, Aguascalientes
                    </p>
                    <a href="https://maps.google.com/?q=TU_DIRECCION_GUADALUPANO" target="_blank"
                        class="btn btn-outline-danger mt-auto">
                        <i class="fa-solid fa-map me-2"></i>Ver en Google Maps
                    </a>
                </div>
            </div>

        </div>
    </section>

    {{-- ===================== WHATSAPP FLOTANTE ===================== --}}
    <a href="https://wa.me/524490000000?text=Hola,%20me%20interesa%20información%20sobre%20sus%20productos"
        target="_blank" class="whatsapp-btn">
        <i class="fa-brands fa-whatsapp fs-4"></i>
        <span>¿Necesitas ayuda?</span>
    </a>

    {{-- ===================== SCRIPTS ===================== --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script>
        // AOS animations
        AOS.init({
            once: false
        });

        // Contador animado
        document.querySelectorAll('.counter').forEach(counter => {
            const target = +counter.dataset.target;
            const step = Math.ceil(target / 60);
            const update = () => {
                const current = +counter.innerText;
                if (current < target) {
                    counter.innerText = Math.min(current + step, target);
                    setTimeout(update, 30);
                } else {
                    // Agregar símbolo + al terminar
                    counter.innerText = target.toLocaleString('es-MX') + '+';
                }
            };
            update();
        });
    </script>
@endsection
