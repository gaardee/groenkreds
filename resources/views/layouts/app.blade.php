<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="https://kit.fontawesome.com/9d663cb7b2.js" crossorigin="anonymous"></script>
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark shadow-sm">
            <div class="container" id="navbar-container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    <img src="{{ url('/images/globus_logo_hvid.svg') }}">
                    {{ mb_strtoupper(config('app.name', 'Laravel')) }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse justify-content-center order-2" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav d-flex align-items-center">
                        <li class="nav-item {{ (request()->is('/') || request()->is('kortet')) ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('kortet') }}">Kortet</a>
                        </li>
                        <li class="nav-item {{ (request()->is('aktiviteter')) ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('aktiviteter') }}">Aktiviteter</a>
                        </li>
                        <li class="nav-item {{ (request()->is('om')) ? 'active' : '' }}">
                            <a class="nav-link" href="{{ route('om') }}">Om GRØN KREDS</a>
                        </li>
                    </ul>
                </div>
                <div class="order-3 d-none d-md-flex align-items-center">
                    <div style="font-size:40pt; margin-right: 5px;">{{ $kredse_count }}</div><div>kredse er med i <br>GRØN KREDS</div>
                </div>
            </div>
        </nav>

        <main class="">
            @yield('content')
        </main>
    </div>
</body>
</html>
