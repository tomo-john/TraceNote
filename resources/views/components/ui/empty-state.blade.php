@props([
    'icon' => '',
    'title' => '',
    'description' => '',
])

<x-ui.card class="py-12">

    <div class="flex flex-col items-center text-center">

        <div class="mb-4 text-4xl text-slate-300">
            <i class="{{ $icon }}"></i>
        </div>

        <h2 class="text-lg font-semibold text-slate-700">
            {{ $title }}
        </h2>

        <p class="mt-2 text-sm text-slate-500">
            {{ $description }}
        </p>

        @if($slot->isNotEmpty())
            <div class="mt-6">
                {{ $slot }}
            </div>
        @endif

    </div>

</x-ui.card>
