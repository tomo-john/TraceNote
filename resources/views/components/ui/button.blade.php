@props([
    'variant' => 'primary',
    'href' => null,
    'type' => 'button',
])

@php

$baseClass = '
    inline-flex
    items-center
    justify-center
    gap-2
    px-5
    py-3
    font-bold
    rounded-xl
    transition-all
    hover:-translate-y-0.5
    hover:shadow-sm
    active:scale-95
';

$classes = match($variant) {
    'primary' => 'bg-slate-700 text-white hover:bg-slate-800',
    'secondary' => 'bg-white text-slate-700 border border-slate-300 hover:bg-stone-50',
    'danger' => 'bg-red-50 text-red-700 border border-red-300 hover:bg-red-100 hover:border-red-400',
    default => 'bg-gray-100 text-black'
};

@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->class([$baseClass, $classes,]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->class([$baseClass, $classes,]) }}>
        {{ $slot }}
    </button>
@endif

