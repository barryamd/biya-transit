<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title') | {{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
{{--        <link rel="stylesheet" href="https://fonts.bunny.net/css2?family=Nunito:wght@400;600;700&display=swap">--}}
        <!-- Google Font: Source Sans Pro -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

        <!-- Font Awesome Solid + Brands -->
        <link href="{{ asset('assets/fontawesome/css/fontawesome.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/fontawesome/css/brands.min.css') }}" rel="stylesheet">
        <link href="{{ asset('assets/fontawesome/css/solid.min.css') }}" rel="stylesheet">
        <!-- update existing v5 CSS to use v6 icons and assets -->
        <link href="{{ asset('assets/fontawesome/css/v5-font-face.min.css') }}" rel="stylesheet">

        <!-- Select2 -->
        <link rel="stylesheet" href="{{ asset('assets/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('assets/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
        <!-- Bootstrap Color Picker -->
        <link rel="stylesheet" href="{{ asset('assets/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css') }}">

        <!-- Scripts -->
{{--        @vite(['resources/css/app.css', 'resources/js/app.js'])--}}

        <!-- Styles -->
        @livewireStyles

        <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
        @stack('styles')

        <!-- SweetAlert2 -->
        <link rel="stylesheet" href="{{ asset('assets/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">

        <!-- Theme style -->
        <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">

        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
        <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    </head>
    <body class="hold-transition sidebar-mini dark-mode">
        <!-- Site wrapper -->
        <div class="wrapper">
            <!-- Preloader -->
{{--            <div class="preloader flex-column justify-content-center align-items-center">--}}
{{--                <img class="animation__shake" src="{{ asset('img/loader.png') }}" alt="SGI Logo">--}}
{{--            </div>--}}

            <!-- Navbar -->
            @livewire('navbar')
            <!-- /.navbar -->

            <!-- Main Sidebar Container -->
            <aside class="main-sidebar sidebar-dark-primary elevation-4">
                <!-- Brand Logo -->
                <a href="{{ route('dashboard') }}" class="brand-link">
{{--                    <img src="{{ asset('uploads/settings/logo.png') }}" alt="Logo" class="brand-image img-circle elevation-3" style="opacity: .8">--}}
                    <span class="brand-text font-weight-light text-bold">{{ config('app.name') }}</span>
                </a>
                <!-- Sidebar -->
                @livewire('sidebar')
                <!-- /.sidebar -->
            </aside>

            <!-- Content Wrapper. Contains page content -->
            <div class="content-wrapper" style="min-height: 1566.44px;">
                <!-- Content Header (Page header) -->
                <section class="content-header">
                    <div class="container-fluid">
                        @if (isset($header))
                            @yield('header_toolbar')
                        @else
                            <div class="row">
                                <div class="col-sm-6">
                                    <h3>@yield('title')</h3>
                                </div>
                                <div class="col-sm-6">
                                    <ol class="breadcrumb float-sm-right">
                                        <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
                                        <li class="breadcrumb-item active">@yield('title')</li>
                                    </ol>
                                </div>
                            </div>
                        @endif
                    </div>
                    <!-- /.container-fluid -->
                </section>

                <!-- Main content -->
                <section class="content">
                    <div class="container-fluid">
                        @isset($slot)
                            {{ $slot }}
                        @else
                            @yield('content')
                        @endif
                    </div>
                </section>
                <!-- /.content -->
            </div>
            <!-- /.content-wrapper -->

            <footer class="main-footer">
                <div class="float-right d-none d-sm-block">
                    <b>Version</b> {{ env('APP_VERSION') }}
                </div>
                <strong>Copyright &copy; {{ date('Y') }} <a href="{{ config('app.url') }}">{{ config('app.name') }}</a>.</strong> All rights reserved.
            </footer>

            <!-- Control Sidebar -->
            <aside class="control-sidebar control-sidebar-dark">
                <!-- Control sidebar content goes here -->
            </aside>
            <!-- /.control-sidebar -->

        </div>
        <!-- ./wrapper -->

        @stack('modals')

        <!-- Scripts -------------------------------------------------------------------------------------------------->
        <!-- jQuery -->
        <script src="{{ asset('assets/jquery/jquery.min.js') }}"></script>
        <!-- Bootstrap 4 -->
        <script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
        <!-- Select2 -->
        <script src="{{ asset('assets/select2/js/select2.full.min.js') }}"></script>
        <script>
            $(document).ready(function () {
                $(".select2").select2({ theme: 'bootstrap4', width: '100%' });
            });
        </script>
        {{--<x:pharaonic-select2::scripts />--}}
        <!-- bootstrap color picker -->
        <script src="{{ asset('assets/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js') }}"></script>

        <!-- Livewire Scripts -->
        @livewireScripts

        @stack('scripts')

        <!-- SweetAlert2 -->
        <script src="{{ asset('assets/sweetalert2/sweetalert2.min.js') }}"></script>
        <x-livewire-alert::scripts />

        <!-- bs-custom-file-input -->
        {{--<script src="{{ asset('assets/bs-custom-file-input/bs-custom-file-input.min.js') }}"></script>--}}
        {{--<script>
            $(function () {
                bsCustomFileInput.init();
            });
        </script>--}}

        <!-- AdminLTE App -->
        <script src="{{ asset('js/adminlte.min.js') }}"></script>
        <!-- AdminLTE for demo purposes -->
        <script src="{{ asset('js/demo.js') }}"></script>

        {{--<script src="https://cdn.jsdelivr.net/gh/livewire/sortable@v0.x.x/dist/livewire-sortable.js"></script>--}}
        {{--<script src="https://unpkg.com/@nextapps-be/livewire-sortablejs@0.1.1/dist/livewire-sortable.js"></script>--}}
    </body>
</html>
