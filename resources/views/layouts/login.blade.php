<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title')</title>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Source+Serif+Pro&display=swap" rel="stylesheet">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/app.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('/css/login.css') }}">
    @livewireStyles
</head>
<body class="s-bg-main">
    <div class="main-wrapper">
        <div class="row h-100">
            <div class="col-5 h-100 s-bg-primary left-wrapper">
                <div class="main-brand d-flex flex-row ">
                    <img src="{{ asset('images/logo-sitikhtiar.png')}}" alt="Logo SIT Ikhtiar" srcset="Logo SIT Ikhtiar">
                    <div class="brand-text">SIT IKHTIAR</div>
                </div>
                <h1>Selamat Datang di E-Raport</h1>
                <p class="mt-5"><b>E-Raport SIT IKHTIAR</b> adalah aplikasi web untuk memudahkan Guru & Walikelas dalam penginputan nilai raport siswa.</p>
            </div>

            <div class="col right-wrapper s-main-text h-100">
                @yield('content')
                <div class="footer w-100 position-absolute">
                    <p class="text-muted text-center">E-Raport SIT Ikhtiar - © 2020</p>
                </div>
            </div>

        </div>
    </div>
    @livewireScripts

    <script src="{{ asset('js/app.js') }}" defer></script>
</body>
</html>
