<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <link rel="icon" type="image/x-icon" href="{{ asset('img/logo.jpg') }}">
</head>
<body>
    @isset($has_order)
    @php $o = $has_order ? '' : 'no-order'; @endphp
    @endisset

    <div id="app" class="{{ @$o }}">
        @include('includes.sidebar')

        @yield('content')
    </div>

    @yield('plugins')
    @yield('scripts')
</body>
</html>
