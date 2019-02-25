<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Laravel</title>

        <!-- Scripts -->
        <script type="text/javascript" src="{{ asset('js/jquery-3.3.1.min.js') }}"></script>

        <!-- Styles -->
        <link rel="stylesheet" href="{{ asset('css/style.css') }}">
        <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css" integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
        @yield('viewcss')
    </head>
    <body>
        <div class="container flex-center">
            <div class="content">
                @yield('content')
                <div id="app"></div>
            </div>
        </div>
    </body>
    <script type="text/javascript" src="{{ asset('js/script.js') }}"></script>
</html>
