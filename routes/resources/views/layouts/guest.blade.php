<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">

        <!-- Scripts -->
    </head>
    <body>
        <div class="font-sans text-gray-900 antialiased">
            {{ $slot }}
        </div>

        <!-- Required Js -->
        <script src="https://code.jquery.com/jquery-3.6.1.min.js" crossorigin="anonymous"></script>

        <script src="{{ asset('js/plugins/popper.min.js') }}"></script>
        <script src="{{ asset('js/plugins/bootstrap.min.js') }}"></script>

        <script src="{{ asset('js/menu-setting.js') }}"></script>
    </body>
</html>
