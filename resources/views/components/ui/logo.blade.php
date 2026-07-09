@props([
    'href' => null,
])

@php

$baseClass = '
    flex
    items-center
    justify-center
    gap-2
    text-lg
    text-slate-500
    font-bold
    hover:opacity-80
    transition
';

$iconClass = '
    w-8
    h-8
';

@endphp

@if($href)

    <a href="{{ $href }}" {{ $attributes->class($baseClass) }}>

        <img src="{{ asset('favicon.svg')}}" alt="Trace Note Logo" class="{{ $iconClass }}">

        Trace Note

    </a>

@else

    <div {{ $attributes->class($baseClass) }}>

        <img src="{{ asset('favicon.svg')}}" alt="Trace Note Logo" class="{{ $iconClass }}">

        Trace Note

    </div>

@endif
