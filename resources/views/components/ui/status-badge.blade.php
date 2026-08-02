@props([
    'status',
])

<span  {{ $attributes->class([
    'rounded-full px-3 py-1 text-xs font-medium inline-flex items-center gap-1 whitespace-nowrap',
    $status->colorClass(),
]) }}>
    <i class="{{ $status->iconClass() }}"></i>
    {{ $status->label() }}
</span>
