<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}@if (isset($header)) - {{ $header }} @endif</title>

        @vite(['resources/scss/app.scss'])
    </head>
    <body class="body">
        <div class="container">
            <div class="row">
                <div class="col">
                    @include('layouts.navigation')
                </div>
            </div>
            <div class="row">
                <div class="col">
                    @if (session()->has('success'))
                        <div class="alert alert-success">
                            {{ session()->get('success')}}
                        </div>
                    @endif
                    @if (session()->has('error'))
                        <div class="alert alert-danger">
                            {{ session()->get('error')}}
                        </div>
                    @endif

                    @if (isset($header))
                        <header class="">
                            <h1>{{ $header }}</h1>
                        </header>
                    @endif

                    <main>
                        @yield('content')
                        {{ $slot ?? '' }}
                    </main>
                </div>
            </div>
        </div>
        @vite(['resources/js/app.js'])
        @stack('scripts')
    </body>
</html>
