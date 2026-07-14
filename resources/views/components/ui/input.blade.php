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
    px-4
    py-3
    text-slate-700
    placeholder:text-slate-400
    outline-none
    transition
';

$stateClass = $errors->has($name)
    ? 'border-rose-500 ring-2 ring-rose-200'
    : 'border-slate-300 focus:border-lime-500 focus:ring-2 focus:ring-lime-200';

@endphp

<input
    id="{{ $id }}"
    name="{{ $name }}"
    type="{{ $type }}"
    value="{{ old($name), $value }}"
    {{ $attributes->class([$baseClass, $stateClass]) }}
>
