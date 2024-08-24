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

    {{-- Bootstrap --}}
    {{-- <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css"> --}}

    <link href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap4.css">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <!-- Scripts -->
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}

    <script src="https://kit.fontawesome.com/44c015b24b.js" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">


    <style>
        .navbar {
            background: #e9183b;
            padding: 0 15px;
        }

        .table thead th {
            background: #e9183b;
            color: white;
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
    </style>
</head>

<body>
    <div class="containeer">
        <nav class="navbar navbar-expand-lg">
            <a class="navbar-brand" href="/home" style="color: white">
                <img src="/assets/img/favicon.ico" width="50" alt="Logo"> Rines Saucedo
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ms-auto">
                    @foreach (Menu() as $Me)
                        @if ($Me->submenu == 1)
                            <li class="nav-item dropdown">
                                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                                    role="button" data-bs-toggle="dropdown" aria-expanded="false" style="color: white">
                                    {{ $Me->nombre }}
                                </a>
                                <ul class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                    @foreach (submenu($Me->id) as $submenu)
                                        <li><a class="dropdown-item"
                                                href="{{ $submenu->url }}">{{ $submenu->nombre }}</a></li>
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
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <form id="logout-form" action="/logout" method="POST">
                            @csrf
                            <button type="submit" class="btn btn-warning">
                                <i class="typcn typcn-power-outline"></i> {{ __('Salir') }}
                            </button>
                        </form>
                    </li>
                </ul>
            </div>
        </nav>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert" id="success-alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif
        <div id="loader"
            style="
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

        @yield('content')

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>


    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">

    {{-- <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script> --}}
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>

    <!-- SweetAlert2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Ocultar el loader una vez que el contenido de la página se haya cargado
            var loader = document.getElementById('loader');
            if (loader) {
                loader.style.display = 'none';
            }
        });

        window.addEventListener("load", function() {
            // Ocultar el loader cuando la página se haya cargado completamente
            var loader = document.getElementById('loader');
            if (loader) {
                loader.style.display = 'none';
            }
        });


        setTimeout(function() {
            const successAlert = document.getElementById('success-alert');
            if (successAlert) {
                successAlert.style.display = 'none';
            }
        }, 5000);
    </script>
</body>

</html>
