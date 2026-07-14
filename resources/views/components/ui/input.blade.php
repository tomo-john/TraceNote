@props([
    'id' => 'null',
    'name',
    'type' => 'text',
    'value' => '',
])

@php

$baseClass = '
    w-full
    rounded-xl
    border
    border-slate-300
    px-4
    py-3
    text-slate-700
    placeholder:text-slate-400
    focus:border-lime-500
    focus:ring-2
    focus:ring-lime-200
    outline-none
    transition
';

@endphp

<input
    id="{{ $id }}"
    name="{{ $name }}"
    type="{{ $type }}"
    value="{{ $value }}"
    {{ $attributes->class($baseClass) }}
>
