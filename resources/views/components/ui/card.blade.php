@php

$baseClass = '
    bg-white
    rounded-2xl
    border
    border-slate-200
    p-6
    shadow-sm
    hover:shadow-lg
    transition
    duration-300
';

@endphp

<div {{ $attributes->class($baseClass) }}>
    {{ $slot }}
</div>
