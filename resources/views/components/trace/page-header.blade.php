@props([
    'title',
    'description' => '',
    'icon' => '',
])

<div class="flex items-end justify-between">

    <div class="space-y-4">

        <h1 class="text-3xl font-bold text-slate-700">

            @if($icon)
                <i class="{{ $icon }}"></i>
            @endif

            {{ $title }}

        </h1>

        @if($description)
            <p class="text-md text-slate-500">
                {{ $description }}
            </p>
        @endif

    </div>

    <div class="flex justify-end gap-2">

        {{ $slot }}

    </div>

</div>

<hr class="border-dashed border-slate-200">
