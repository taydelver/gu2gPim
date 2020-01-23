<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Admin Page') }}</title>
    <script src="https://kit.fontawesome.com/c927a46be2.js" crossorigin="anonymous"></script>
    <!-- Scripts -->
    <script src="{{ asset('js/admin.js') }}" defer></script>
    <link href="https://cdn.quilljs.com/1.2.6/quill.snow.css" rel="stylesheet">

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Styles -->
    
    <link href="{{ asset('css/nucleo.css') }}" rel="stylesheet">
    <link href="{{ asset('css/argon.css') }}" rel="stylesheet">
    <link href="{{ asset('css/admin.css') }}" rel="stylesheet">
    
</head>
<body>
    <div id="admin">
        @include('partials.sidebar')
        @include('partials.navbar')
        <main class="main-content-right">
        
                @yield('page-title')
     
            @yield('content')
        </main>
    </div>
</body>
</html>
