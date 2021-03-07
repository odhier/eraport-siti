<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@stack('pagetitle') -  {{ config('app.name') }}</title>

    <!-- Scripts -->
    <script src="{{ asset(Mix('js/app.js'))}}" defer data-turbolinks-track="reload"></script>

    <livewire:scripts />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    {{-- <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.x.x/dist/alpine.min.js" defer></script> --}}
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.1/dist/alpine.min.js" defer></script>



    @stack('scripts')

    <!-- Styles -->
    <livewire:styles/>

    <link rel="stylesheet" data-turbolinks-track="reload" href="{{ asset('/css/tailwind.css') }}" media="all">

    <link rel="stylesheet" data-turbolinks-track="reload" href="{{ asset('/css/app.css') }}" media="all">
    <link rel="stylesheet" data-turbolinks-track="reload" href="{{ asset('/css/style.css') }}" media="all" >

    @stack('styles')
</head>
<body class="s-bg-primary">
    <div class="main-wrapper">
        <div class="row h-100">
            <div class="col-2 h-100 s-bg-primary left-wrapper py-3">
                <div class="profile text-center my-3">
                    @empty(!Auth::user()->picture)
                    <div class="pict mx-auto mb-2" style="background-image: url('{{asset('storage/'.Auth::user()->picture)}}'); height: 150px; width:150px;border-radius: 15px;
                        background-position: center;
                        background-repeat: no-repeat;
                        background-size: cover;">
                    </div>
                    @else
                    <div class="pict mx-auto mb-2" style="background-image: url('https://ui-avatars.com/api/?name={{Auth::user()->name}}&background=0D8ABC&color=fff&size=150'); height: 150px; width:150px;border-radius: 15px;
                        background-position: center;
                        background-repeat: no-repeat;
                        background-size: cover;">
                    </div>
                    @endif
                    <div class="name ">{{ strtoupper(Auth::user()->name) }}</div>
                    <div class="email">{{ Auth::user()->email}}</div>
                </div>
                <livewire:menubar />



            </div>

            <div class="col-10 right-wrapper s-main-text " style="height:auto" data-turbolinks-eval=“false”>


                {{ $slot }}

            </div>

        </div>
    </div>

    <script>
        window.addEventListener('closeModal', event => {
            $(".modal").modal('hide');
        });
        window.addEventListener('focusSiswaOut', event => {
            $(".blocker").css("display", "none");
            $(".result-student-search").css("display", "none");
        });
        window.addEventListener('focusLast', event => {
            document.getElementById(event.detail.id).focus();
        });
        document.addEventListener('DOMContentLoaded', function(event) {
            $('body').tooltip({selector: '[data-toggle="tooltip"]'});
    });
    </script>

@stack('scripts-bottom')
</body>
</html>
