<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    @include('partials.head')
</head>
<body class="min-h-screen bg-slate-50 text-slate-900 flex flex-col">

    {{-- Header --}}
    <x-layouts.partials.header />

    {{-- Main --}}
    <main class="flex-1">
        {{ $slot }}
    </main>

    <x-ui.toast />

    {{-- Footer --}}
    <x-layouts.partials.footer />

    @fluxScripts
</body>
</html>
