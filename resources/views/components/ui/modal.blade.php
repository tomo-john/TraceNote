@props([
    'size' => 'sm',
    'close' => '',
    'showCloseButton' => true,
    'blur' => true,
    'persistent' => false,
])

@php

$baseClass = '
    w-full
    relative
';

$maxWidth = match($size) {
    'sm' => 'max-w-sm',
    'md' => 'max-w-xl',
    'lg' => 'max-w-3xl',
    default => 'max-w-md',
};

@endphp

<div
    class="
        fixed inset-0 z-50
        flex items-center justify-center
        bg-slate-900/60
        {{ $blur ? 'backdrop-blur-sm' : '' }}
    "
    @if(! $persistent)
        @keydown.escape.window="$wire.{{ $close }}()"
        @click.self="$wire.{{ $close }}()"
    @endif
>

    <x-ui.card {{ $attributes->class([$baseClass, $maxWidth]) }}>
        {{ $slot }}

        {{-- Close Button --}}
        @if($showCloseButton)

            <button
                type="button"
                wire:click="{{ $close }}"
                class="absolute top-4 right-4 cursor-pointer w-8 h-8 rounded-lg text-slate-400 hover:text-slate-700 hover:bg-slate-100 transition"
            >
                <i class="fa-solid fa-xmark"></i>
            </button>
        @endif
    </x-ui.card>
</div>
