<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>

        <title>{{ config('app.name', 'Laravel') }}</title>
        <!-- HTML5 Shim and Respond.js IE11 support of HTML5 elements and media queries -->
        <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
        <!--[if lt IE 11]>
                <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
                <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
                <![endif]-->
        <!-- Meta -->

        <meta name="csrf-token" content="{{ csrf_token() }}">

        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="description" content="" />
        <meta name="keywords" content="">
        <meta name="author" content="Codedthemes" />
        <!-- Favicon icon -->
        <link rel="icon" href="{{asset('images/favicon.ico')}}" type="image/x-icon">

        <link rel="stylesheet" href="{{asset('plugins/jquery-confirm/jquery-confirm.min.css')}}">

        <!-- vendor css -->
        <link rel="stylesheet" href="{{asset('css/style.css')}}">
        <link rel="stylesheet" href="{{asset('css/custom.css')}}">
        <!-- Fonts -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">

        @stack('styles')

    </head>
    <body class="">

<!--        <div class="loader-bg">
            <div class="loader-track">
                <div class="loader-fill"></div>
            </div>
        </div>-->

        @include('layouts.left-menu')
        @include('layouts.top-bar')
        
        {{ $slot }}
        
        
        <script src="{{asset('js/jquery.min.js')}}"></script>
        <script src="{{asset('js/popper.min.js')}}"></script>
        <script src="{{asset('js/perfect-scrollbar.min.js')}}"></script>
        <script src="{{asset('js/bootstrap.min.js')}}"></script>
        <script src="{{asset('js/pcoded.js')}}"></script>
        <script src="{{asset('plugins/jquery-confirm/jquery-confirm.min.js')}}"></script>
        <script src="{{asset('js/loadingoverlay.min.js')}}"></script>
        
        <script src="{{asset('js/menu-setting.js')}}"></script>
        <!-- custom-chart js -->
        @include('layouts.notification')
        @routes
        <script src="{{asset('js/common.js')}}"></script>
        @stack('scripts')

    </body>
</html>
