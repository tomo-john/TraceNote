@props([
    'href' => null,
    'type' => 'button',
    'danger' => false,
])

@php

$baseClass = '
    flex
    items-center
    gap-2
    w-full
    px-3
    py-2
    rounded-xl
    transition
    duration-300
    cursor-pointer
';

$classes = $danger
    ? 'text-rose-600 hover:bg-rose-50 hover:text-rose-700'
    : 'text-slate-600 hover:bg-slate-100 hover:text-slate-900';

@endphp

@if($href)
    <a href="{{ $href }}" {{ $attributes->class([$baseClass, $classes]) }}>
        {{ $slot }}
    </a>
@else
    <button type="{{ $type }}" {{ $attributes->class([$baseClass, $classes]) }}>
        {{ $slot }}
    </button>
@endif
