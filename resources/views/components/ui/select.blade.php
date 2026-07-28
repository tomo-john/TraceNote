@props([
    'id' => null,
    'name' => null,
])

@php

$baseClass = '
    w-full
    rounded-xl
    border
    border-slate-300
    bg-white
    px-4
    py-3
    text-slate-700
    outline-none
    transition
    focus:border-lime-500
    focus:ring-2
    focus:ring-lime-200
';

@endphp

<select
    id="{{ $id }}"
    name="{{ $name }}"
    {{ $attributes->class($baseClass) }}
>
    {{ $slot }}
</select>
