@props([
    'maxWidth' => 'sm',
    'close' => '',
])

@php

$baseClass = '

';

$width = match($maxWidth) {
    'sm' => 'max-w-sm',
    'md' => 'max-w-xl',
    'lg' => 'max-w-3xl',
    default => 'max-w-md',
};

@endphp

<div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/60"
     @keydown.escape.window="$wire.{{ $close }}()"
     @click.self="$wire.{{ $close }}()"
>

    <x-ui.card {{ $attributes->class(['w-full', $width]) }}>
        {{ $slot }}
    </x-ui.card>
</div>
