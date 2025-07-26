<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    {{--
    <link href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap4.css">--}}

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Scripts -->
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}

    <script src="https://kit.fontawesome.com/44c015b24b.js" crossorigin="anonymous"></script>

    <link href="/assets/DataTables/datatables.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


    <style>
        html,
        body {
            height: 100%;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        .containeer {
            flex: 1;
            /* Hace que el contenido principal ocupe el espacio disponible */
        }

        footer {
            background: #e9183b;
            color: white;
            text-align: center;
            padding: 20px 0;
        }

        .navbar {
            background: #e9183b;
            padding: 0 15px;
        }

        .table thead th {
            background: #e9183b !important;
            color: white !important;
        }

        .table tbody tr:hover td {
            background: #ffc7d0 !important;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        #loader .loading-text {
            margin-top: 20px;
            /* Espacio entre la imagen y el texto */
            font-size: 24px;
            color: #fff;
            /* Color blanco para el texto */
        }

        body {
            background: rgba(0, 0, 0, 0.05);
        }

        .fixed-button {
            position: fixed;
            bottom: 20px;
            /* Ajusta la distancia desde el fondo de la pantalla */
            right: 20px;
            /* Ajusta la distancia desde el borde derecho de la pantalla */
            z-index: 1000;
            /* Asegura que el botón esté por encima de otros elementos */
            padding: 10px;
        }

        body.modal-open {
            position: static !important;
            overflow: visible !important;
        }

        #particles-js {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            z-index: -1;
        }

        .main-content {
            position: relative;
            z-index: 1;
        }

        .count-particles {
            display: none;
        }
    </style>
</head>

<body>
    <div class="containeer">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href="{{ Auth::check() ? '/home' : '/' }}" style="color: white">
                <img src="/assets/img/favicon.ico" width="50" alt="Logo"> Rines Saucedo
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto text-center">
                    @auth
                        @foreach (Menu() as $Me)
                            @if ($Me->submenu == 1)
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink" role="button"
                                        data-bs-toggle="dropdown" aria-expanded="false" style="color: white">
                                        {{ $Me->nombre }}
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                        @foreach (submenu($Me->id) as $submenu)
                                            <li><a class="dropdown-item" href="{{ $submenu->url }}">{{ $submenu->nombre }}</a></li>
                                        @endforeach
                                    </ul>
                                </li>
                            @else
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ $Me->url }}" role="button" aria-expanded="false"
                                        style="color: white">
                                        {{ $Me->nombre }}
                                    </a>
                                </li>
                            @endif
                        @endforeach
                    @endauth
                </ul>
                <ul class="navbar-nav mt-2 mb-2 text-center">
                    <li class="nav-item ">
                        @auth
                            <form id="logout-form" action="/logout" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-warning">
                                    <i class="fa-solid fa-right-to-bracket"></i> {{ __('Salir') }}
                                </button>
                            </form>
                        @endauth
                        @guest
                            <a href="/login" class="btn btn-warning">
                                <i class="fa-solid fa-user"></i> Login
                            </a>
                        @endguest
                    </li>
                </ul>
            </div>
        </nav>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show text-center" role="alert" id="success-alert"
                style="margin: 20px 40px;">
                <div class="d-flex align-items-center text-center">
                    <i class="bi bi-check-circle-fill me-2" style="font-size: 1.5rem;"></i>
                    <div>
                        <strong>¡Éxito!</strong> {{ session('success') }}
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @elseif (session('error'))
            <div class="alert alert-danger alert-dismissible fade show text-center" role="alert" id="error-alert"
                style="margin: 20px 0;">
                <div class="d-flex align-items-center text-center">
                    <i class="bi bi-x-circle-fill me-2" style="font-size: 1.5rem;"></i>
                    <div>
                        <strong>¡Error!</strong> {{ session('error') }}
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif


        <div id="loader" style="
            position: fixed;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            z-index: 9999;
            background: rgba(0, 0, 0, 0.9); /* Fondo más oscuro */
            display: flex;
            flex-direction: column; /* Alineación vertical */
            justify-content: center;
            align-items: center;
            ">
            <img src="/assets/img/Icono.png" alt="Loading"
                style="width: 100px; height: 100px; animation: spin 2s linear infinite;">
            <div class="loading-text">Cargando...</div>
        </div>

        <div id="particles-js"></div>
        <div class="count-particles"> <span class="js-count-particles"></span></div>


        @yield('content')
    </div>

    <footer class="text-white py-4 mt-5" style="background: #e9183b">
        <div class="container">
            <div class="row">
                <!-- Logo -->
                <div class="col-md-4 d-flex justify-content-center align-items-center mb-3 mb-md-0">
                    <img src="/assets/img/favicon.ico" alt="Logo" style="max-width: 150px;">
                </div>

                <!-- Número de Contacto y WhatsApp -->
                <div class="col-md-4 text-center mb-3 mb-md-0">
                    <p class="mb-2">Contáctanos al:</p>
                    <p class="h5">
                        <i class="fab fa-whatsapp"></i> +52 449 274 77 72
                    </p>
                    <p class="h5">
                        <i class="fab fa-whatsapp"></i> +52 449 777 44 60
                    </p>
                    {{-- <p class="mb-0">
                        <a href="https://wa.me/123456789" class="text-white" target="_blank">
                            <i class="fab fa-whatsapp fa-2x"></i> WhatsApp
                        </a>
                    </p> --}}
                </div>

                <!-- Redes Sociales -->
                <div class="col-md-4 text-center">
                    <p class="mb-2">Síguenos en nuestras redes sociales:</p>
                    <div>
                        <a href="https://www.facebook.com/profile.php?id=100054294079969&locale=es_LA"
                            class="text-white mx-2" target="_blank">
                            <i class="fab fa-facebook fa-2x"></i>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </footer>


    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    {{--
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css"> --}}

    {{--
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
        </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
        </script>

    <script src="/assets/DataTables/datatables.min.js"></script>
    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="http://cdn.jsdelivr.net/particles.js/2.0.0/particles.min.js"></script> <!-- stats.js lib -->
    <script src="http://threejs.org/examples/js/libs/stats.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            // Ocultar el loader una vez que el contenido de la página se haya cargado
            var loader = document.getElementById('loader');
            if (loader) {
                loader.style.display = 'none';
            }
        });

        window.addEventListener("load", function () {
            // Ocultar el loader cuando la página se haya cargado completamente
            var loader = document.getElementById('loader');
            if (loader) {
                loader.style.display = 'none';
            }
        });


        setTimeout(function () {
            const successAlert = document.getElementById('success-alert');
            if (successAlert) {
                successAlert.style.display = 'none';
            }
        }, 8000);
    </script>
    <script>
        particlesJS("particles-js", {
            particles: {
                number: {
                    value: 178,
                    density: {
                        enable: true,
                        value_area: 800
                    }
                },
                color: {
                    value: "#ff0000"
                },
                shape: {
                    type: "circle",
                    stroke: {
                        width: 0,
                        color: "#ff0000"
                    },
                    polygon: {
                        nb_sides: 5
                    },
                    image: {
                        src: "img/github.svg",
                        width: 100,
                        height: 100
                    }
                },
                opacity: {
                    value: 0.1,
                    random: false,
                    anim: {
                        enable: false,
                        speed: 1,
                        opacity_min: 0.1,
                        sync: false
                    }
                },
                size: {
                    value: 3,
                    random: true,
                    anim: {
                        enable: false,
                        speed: 40,
                        size_min: 0.1,
                        sync: false
                    }
                },
                line_linked: {
                    enable: true,
                    distance: 150,
                    color: "#ff0000",
                    opacity: 0.2,
                    width: 1
                },
                move: {
                    enable: true,
                    speed: 6,
                    direction: "none",
                    random: false,
                    straight: false,
                    out_mode: "out",
                    bounce: false,
                    attract: {
                        enable: false,
                        rotateX: 600,
                        rotateY: 1200
                    }
                }
            },
            interactivity: {
                detect_on: "canvas",
                events: {
                    onhover: {
                        enable: true,
                        mode: "repulse"
                    },
                    onclick: {
                        enable: true,
                        mode: "push"
                    },
                    resize: true
                },
                modes: {
                    grab: {
                        distance: 400,
                        line_linked: {
                            opacity: 1
                        }
                    },
                    bubble: {
                        distance: 400,
                        size: 40,
                        duration: 2,
                        opacity: 8,
                        speed: 3
                    },
                    repulse: {
                        distance: 200,
                        duration: 0.4
                    },
                    push: {
                        particles_nb: 4
                    },
                    remove: {
                        particles_nb: 2
                    }
                }
            },
            retina_detect: true
        });
    </script>

</body>

</html>