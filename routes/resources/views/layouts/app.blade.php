<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

    <link href="{{ asset('css/plugins/jquery-confirm.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/jquery-ui.min.css') }}" rel="stylesheet">
    <link href="{{ asset('css/plugins/select2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/plugins/daterange-picker.css') }}">
    <!-- CSS -->

    <link rel="stylesheet" href="{{ asset('css/plugins/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">


    @stack('styles')

    <!-- Scripts -->

    @livewireStyles
</head>

<body>

    @include('layouts.navigation')

    @include('layouts.header')


    {{ $slot }}

    @routes

    <!-- Required Js -->
    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/plugins/popper.min.js') }}"></script>
    <script src="{{ asset('js/plugins/perfect-scrollbar.min.js') }}"></script>
    <script src="{{ asset('js/plugins/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/pcoded.js') }}"></script>

    <script src="{{ asset('js/plugins/moment.min.js') }}"></script>
    <script src="{{ asset('js/plugins/loadingoverlay.min.js') }}"></script>
    <script src="{{ asset('js/plugins/jquery-confirm.min.js') }}"></script>
    <script src="{{ asset('js/plugins/jquery-ui.min.js') }}"></script>
    <script src="{{ asset('js/plugins/lodash.min.js') }}"></script>
    <script src="{{ asset('js/plugins/select2.min.js') }}"></script>

    <script src="{{ asset('js/common.js') }}"></script>

    @stack('scripts')

    @include('layouts.notification')

    @livewireScripts
</body>

</html>
