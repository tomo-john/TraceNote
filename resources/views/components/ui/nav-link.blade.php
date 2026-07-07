@props([
    'variant' => 'primary',
    'href' => '#',
])

@php

$baseClass = '
    text-slate-600
    hover:text-slate-500
    transition
'

@endphp

<a href="{{ $href }}" {{ $attributes->class($baseClass) }}>
    {{ $slot }}
</a>

