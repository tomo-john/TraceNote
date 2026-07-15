@props([
    'sidebar' => false,
    'app_name' => 'Trace Note',
])

@if($sidebar)
    <flux:sidebar.brand :name="$app_name" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-md bg-transparent text-accent-foreground">
            <x-app-logo-icon class="size-6 text-lime-500" />
        </x-slot>
    </flux:sidebar.brand>
@else
    <flux:sidebar.brand :name="$app_name" {{ $attributes }}>
        <x-slot name="logo" class="flex aspect-square size-8 items-center justify-center rounded-md bg-transparent text-accent-foreground">
            <x-app-logo-icon class="size-6 text-lime-500" />
        </x-slot>
    </flux:sidebar.brand>
@endif
