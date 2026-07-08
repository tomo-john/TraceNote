@props([
    'variant' => 'primary',
    'href' => '#',
])

@php

$baseClass = '
    transition
    duration-300
';

$classes = match($variant) {
    'primary' => 'text-slate-600 hover:text-slate-400',
    'special' => 'text-pink-600 hover:text-pink-400',
    default => ''
};

@endphp

<a href="{{ $href }}" {{ $attributes->class([$baseClass, $classes]) }}>
    {{ $slot }}
</a>

