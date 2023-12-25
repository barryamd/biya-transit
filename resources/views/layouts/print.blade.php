<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>AdminLTE 3 | Invoice Print</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">

    <!-- Livewire Styles -->
    <livewire:styles />
    <script src="{{ asset('js/alpine.js') }}" defer></script>

    @stack('styles')

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
</head>
<body class="layout-footer-fixed" style="font-size: 1.2rem">
    <div class="wrapper">
        <!-- Header -->
        <header class="row" style="border-bottom: 3px solid black">
            <div class="col-3 p-4" style="height: 165px">
                <img src="{{ asset('uploads/'.$setting->logo) }}" height="100%">
            </div>
            <div class="col-7 pt-2" style="height: 180px">
                <h2 class="text-uppercase text-2xl text-center text-bold">{{ $setting->name }}</h2>
                <h4 class="text-center text-bold">{{ $setting->acronym }}</h4>
                <address class="text-center text-lg">
                    <b>Téléphone :</b> {{ $setting->phone1 }}/{{ $setting->phone2 }}<br/>
                    <b>Email :</b> {{ $setting->email }}<br/>
                    <b>BP : {{ $setting->postcode }}</b> Conakry Guinee<br/>
                </address>
            </div>
            <div class="col-2 pt-4" style="height: 140px">
                {!! QrCode::generate($folder->number) !!}
            </div>
        </header>
        <br>

        <!-- Main content -->
        <section class="invoice">
            @yield('content')
        </section>

        <!-- Footer -->
        <footer class="main-footer text-center">
            {{ $setting->address }}
        </footer>
    </div>

    <!-- Scripts -------------------------------------------------------------------------------------------------->
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

    <!-- Livewire Scripts -->
    <livewire:scripts />

    @stack('scripts')

    <!-- AdminLTE App -->
    <script src="{{ asset('js/adminlte.min.js') }}"></script>
</body>
</html>
