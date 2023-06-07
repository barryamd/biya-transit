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
                <img src="{{ asset('uploads/'.$shop->logo) }}" height="100%">
            </div>
            <div class="col-7 pt-2" style="height: 140px">
                <h2 class="text-center text-bold">{{ $shop->name }}</h2>
                <address class="text-center text-lg">
                    {{ $shop->address }}<br>
                    <b>Email:</b> {{ $shop->email }}<br/>
                    <b>Contacts:</b> {{ $shop->phone1 }}, {{ $shop->phone1 }}<br/>
                </address>
            </div>
            @isset($reparation)
            <div class="col-2 pt-4" style="height: 140px">
                {!! QrCode::generate(isset($sale) ? $sale->number : $reparation->repair_code) !!}
                {{--<div class="text-center text-bold">{{ $shop->phone1 }}</div>
                <div class="text-center text-bold">{{ $shop->phone2 }}</div>
                <div class="text-center text-bold">{{ $shop->phone3 }}</div>--}}
            </div>
            @endisset
        </header>
        <br>

        <!-- Main content -->
        <section class="invoice">
            @isset($slot)
                {{ $slot }}
            @else
                @yield('content')
            @endisset
        </section>

        @if((!isset($footer) || $footer) && isset($shop))
        <!-- Footer -->
        <footer class="main-footer">
            {{--
            <p style="margin-left:15px;">
                RCCM/GC-KAL/023.754/2008 -SA. 50 000.000 FG -RCCM/GC-KAL/022.103A/2008 - TVA : {{ $shop->vat_no }} NIF: {{ $shop->nif }}
            </p>
            <div class="table-responsive">
                <table class="table">
                    <table class="table">
                        <tr>
                            <td>Code Banque</td>
                            <td>Code Agence</td>
                            <td>N° compte</td>
                            <td>Cle</td>
                        </tr>
                        <tr>
                            <td>{{ $shop->bank_code }}</td>
                            <td>{{ $shop->agenbcy_code }}</td>
                            <td>{{ $shop->account_number }}</td>
                            <td>{{ $shop->cle }}</td>
                        </tr>
                        <tr>
                            <td>
                                <p>IBAN : {{ $shop->iban }}	BIC : {{ $shop->bic }}</p>
                            </td>
                        </tr>
                    </table>
                </table>
            </div>
            --}}
        </footer>
        @endif
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
    <script>
        window.addEventListener("load", window.print());
    </script>
</body>
</html>
