<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">

    <!-- Font Awesome Solid + Brands -->
    <link href="{{ asset('assets/fontawesome/css/fontawesome.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/fontawesome/css/brands.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/fontawesome/css/solid.min.css') }}" rel="stylesheet">
    <!-- update existing v5 CSS to use v6 icons and assets -->
    <link href="{{ asset('assets/fontawesome/css/v5-font-face.min.css') }}" rel="stylesheet">

    <!-- icheck bootstrap -->
    <link rel="stylesheet" href="{{ asset('assets/icheck-bootstrap/icheck-bootstrap.min.css') }}">

    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('css/adminlte.min.css') }}">
    <script src="{{ asset('js/alpine.js') }}" defer></script>
</head>
<body class="hold-transition login-page">
<div>
    {{ $slot }}
</div>

<!-- Scripts -->
<!-- jQuery -->
<script src="{{ asset('assets/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap 4 -->
<script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE App -->
<script src="{{ asset('js/adminlte.min.js') }}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{ asset('js/demo.js') }}"></script>
</body>
</html>
