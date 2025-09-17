<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Corretor Imóveis') }} - @yield('title', 'Sistema de Corretagem')</title>

    <!-- SEO Meta Tags -->
    <meta name="description" content="@yield('meta-description', 'Plataforma completa para corretagem de imóveis - compre, venda e alugue imóveis')">
    <meta name="keywords" content="@yield('meta-keywords', 'imóveis, corretor, apartamento, casa, venda, aluguel, São Paulo')">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Additional CSS -->
    @stack('styles')

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
</head>
<body class="font-sans antialiased bg-gray-50">
    <div class="min-h-screen">
        @include('layouts.navigation')

        <!-- Page Content -->
        <main class="flex-1">
            @yield('content')
        </main>

        @include('layouts.footer')
    </div>

    <!-- Global Scripts -->
    @stack('scripts')
</body>
</html>