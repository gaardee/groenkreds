<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <link rel="apple-touch-icon" sizes="180x180" href="/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon/favicon-16x16.png">
    <link rel="manifest" href="/favicon/site.webmanifest">
    <link rel="mask-icon" href="/favicon/safari-pinned-tab.svg" color="#5bbad5">
    <link rel="shortcut icon" href="/favicon/favicon.ico">
    <meta name="msapplication-TileColor" content="#da532c">
    <meta name="msapplication-config" content="/favicon/browserconfig.xml">
    <meta name="theme-color" content="#ffffff">

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.3/css/all.css" integrity="sha384-SZXxX4whJ79/gErwcOYf+zWLeJdY/qpuqC4cAa9rOGUstPomtqpuNWT9wdPEn2fk" crossorigin="anonymous">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-dark shadow-sm">
            <div class="container-fluid px-5" id="navbar-container">
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
                        @foreach($pages AS $page)
                            <li class="nav-item {{ (request()->is($page->slug)) ? 'active' : '' }}">
                                <a class="nav-link" href="{{ route('page', [$page->slug]) }}">{{ $page->navn }}</a>
                            </li>
                        @endforeach
                        <li class="d-flex align-items-center justify-content-between d-md-none" style="width: 100%; padding: 0px 4rem;">
                            <div class="d-flex align-items-center">
                                <div style="font-size:40pt; margin-right: 5px;">{{ $kredse_count }}</div>
                                <div>kredse er med i <br>GRØN KREDS</div>
                            </div>
                            <div>
                                <a href="https://fdf.dk" target="_blank"><img src="/images/FDFskjold.png" style="height: 40px;margin:3px;"></a>
                                <a href="https://www.noedhjaelp.dk/" target="_blank"><img src="/images/folkekirkens_nodhjaelp_logo.svg" style="height: 40px;margin:3px;"></a>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="order-3 d-none d-md-flex align-items-center">
                    <div style="font-size:40pt; margin-right: 5px;">{{ $kredse_count }}</div>
                    <div>kredse er med i <br>GRØN KREDS</div>
                    <div>
                        <a href="https://fdf.dk" target="_blank"><img src="/images/FDFskjold.png" style="height: 40px;margin:3px;"></a>
                        <a href="https://www.noedhjaelp.dk/" target="_blank"><img src="/images/folkekirkens_nodhjaelp_logo.svg" style="height: 40px;margin:3px;"></a>
                    </div>
                </div>
            </div>
        </nav>

        <main class="">
            @yield('content')
        </main>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
    <script src="{{ mix('js/app.js') }}" defer></script>
    @yield('scripts')
</body>
</html>
