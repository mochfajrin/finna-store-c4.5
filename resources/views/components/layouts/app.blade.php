@props(['title'])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ isset($title) ? $title . ' - ' : '' }} {{ config('app.name', '') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased">
    @include('layouts.partials.header')
    {{-- @yield('hero') --}}
    <main class="container mx-auto px-5 flex flex-grow">
        {{ $slot }}
    </main>
    @include('layouts.partials.footer')

    {{-- @stack('modals')
    @livewireScripts --}}
</body>

</html>
