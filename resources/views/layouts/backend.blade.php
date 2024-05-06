<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name') }} | @yield('title')</title>
        <link rel="icon" href="{{ asset('/storage/favicon.png') }}">
        
        @stack('before-styles')
            <link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}"></link>
            <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
            <link rel="stylesheet" href="{{ asset('css/select2.css') }}"></link>
            <link rel="stylesheet" href="{{ asset('css/backend.css') }}"></link>
        @stack('after-styles')
    </head>

    <body>
        <div id="app">
            <x-navigation></x-navigation>

            <div class="wrapper">
                <x-sidebar></x-sidebar>

                <div class="content">
                    @yield('content')
                </div>
            </div>

            @stack('before-scripts')
                <script src="{{ asset('js/jquery.js') }}"></script>
                <script src="{{ asset('js/ckeditor.js') }}"></script>
                <script src="{{ asset('js/select2.js') }}"></script>
                <script src="{{ asset('js/bootstrap.js') }}"></script>
                <script src="{{ asset('js/sidebar.js') }}"></script>
                <script src="{{ asset('js/backend.js') }}"></script>
            @stack('after-scripts')
        </div>
    </body>

</html>