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
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">

    <link href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.2/css/bootstrap.css">
    <link href="https://cdn.datatables.net/2.0.8/css/dataTables.bootstrap4.css">

    <!-- Scripts -->
    {{-- @vite(['resources/sass/app.scss', 'resources/js/app.js']) --}}

    <style>
        .navbar {
            background: #e9183b;
        }
    </style>
</head>

<body>
    <div class="containeer">
        <nav class="navbar navbar-expand-lg navbar-light">
            <a class="navbar-brand" href="/home" style="color: white"><img src="/assets/img/favicon.ico"
                    width="50"> Rines
                Saucedo</a>
            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown"
                aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavDropdown">
                <ul class="navbar-nav ml-auto">
                    @foreach (Menu() as $Me)
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdownMenuLink"
                                role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                                style="color: white">
                                {{ $Me->nombre }}</a>
                            <div class="dropdown-menu" aria-labelledby="navbarDropdownMenuLink">
                                @foreach (submenu($Me->id) as $submenu)
                                    <a class="dropdown-item" href="{{ $submenu->url }}">{{ $submenu->nombre }}</a>
                                @endforeach
                            </div>
                        </li>
                    @endforeach
                </ul>
                <ul class="navbar-nav ml-auto">
                    <form id="logout-form" action="/logout" method="POST">
                        @csrf
                        <button type="submit" class="btn btn-warning"><i class="typcn typcn-power-outline"></i>
                            {{ __('Salir') }}</button>
                    </form>
                </ul>
            </div>
        </nav>

        @if (session('success'))
            <div class="alert alert-success" id="success-alert">
                {{ session('success') }}
            </div>
        @endif


        @yield('content')

    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap5.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap5.min.css">

    <script>
        setTimeout(function() {
            const successAlert = document.getElementById('success-alert');
            if (successAlert) {
                successAlert.style.display = 'none';
            }
        }, 5000);
    </script>
</body>

</html>
