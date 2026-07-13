@props([
    'href' => '#',
])

@php

$baseClass = '
    text-sm
    text-slate-500
    hover:text-lime-600
    hover:underline
    hover:decoration-lime-600
    underline-offset-4
    transition
';

@endphp

<a href="{{ $href }}" {{ $attributes->class($baseClass) }}>
    {{ $slot }}
</a>
