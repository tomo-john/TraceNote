@props([
    'href' => '#',
])

@php

$baseClass = '
    text-sm
    text-slate-500
    hover:text-lime-600
    hover:under-line
    underline-offset-4
    transition
';

@endphp

<a href="{{ $href }}" {{ $attributes->class($baseClass) }}>
    {{ $slot }}
</a>
