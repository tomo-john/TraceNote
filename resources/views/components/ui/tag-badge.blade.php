@props([
    'tag',
])

<span  {{ $attributes->class([
    'rounded-full px-3 py-1 text-xs font-medium',
    $tag->colorClass(),
]) }}>
    {{ $tag->name }}
</span>
