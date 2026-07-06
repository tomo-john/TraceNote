@props([
    'variant' => 'primary',
    'href' => null,
    'type' => 'button',
])

@php
    $baseClass = 'inline-block px-2 py-1 rounded-xl';

    $classes = match($variant) {
        'primary' => 'bg-slate-700 text-white',
        default => 'bg-gray-100 text-black'
    };
@endphp

@if($href)
    <a href="{{ $href }}" class="{{ $baseClass }} {{ $classes }}">
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" class="{{ $baseClass }} {{ $classes }}">
        {{ $slot }}
    </button>
@endif

