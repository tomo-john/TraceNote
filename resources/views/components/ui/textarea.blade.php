@props([
    'id' => null,
    'name',
    'rows' => 5,
    'value' => '',
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
    placeholder:text-slate-400
    outline-none
    transition
    resize-y
';

$stateClass = $errors->has($name)
    ? 'border-rose-500 ring-2 ring-rose-200'
    : 'border-slate-300 focus:border-lime-500 focus:ring-2 focus:ring-lime-200';

@endphp

<textarea
    id="{{ $id }}"
    name="{{ $name }}"
    rows="{{ $rows }}"
    {{ $attributes->class([$baseClass, $stateClass]) }}
>{{ old($name, $value) }}</textarea>
