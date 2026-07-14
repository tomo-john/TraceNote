@props([
    'name',
])

@error($name)
    <p class="text-sm text-rose-600 flex items-center gap-2">
        <i class="fa-solid fa-circle-exclamation"></i>
        {{ $message }}
    </p>
@enderror
