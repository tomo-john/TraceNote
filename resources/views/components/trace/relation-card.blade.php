@props([
    'traces',
    'relationType',
])

<x-ui.card>

    <h2 class="text-md font-bold text-slate-800 flex items-center gap-2">
        <i class="fa-solid fa-link"></i>
        {{ $relationType->label() }}
    </h2>

    @forelse($traces as $trace)

        <div class="flex items-center justify-between rounded-2xl px-2 py-1 hover:bg-slate-50 transition">

            <a
                href="{{ route('trace.show', $trace) }}"
                wire:navigate
                class="flex items-center gap-2 min-w-0"
            >
                <i class="fa-regular fa-file-lines text-slate-400"></i>

                <span class="truncate">
                    {{ $trace->title }}
                </span>
            </a>

            <button
                wire:click="removeRelation({{ $trace->id }})"
                wire:confirm="関連付けを解除しますか？"
                class="rounded-2xl p-2 text-slate-400 transition hover:bg-red-50 hover:text-red-500"
            >
                <i class="fa-solid fa-link-slash"></i>
            </button>

        </div>

    @empty

        <p class="mt-3 text-sm text-slate-500">
            {{ $relationType->label() }}はありません
        </p>

    @endforelse

    <button
        wire:click="openAddRelationModal('{{ $relationType->value }}')"
        class="mt-4 w-full rounded-lg border border-dashed border-slate-300 py-2 text-sm text-slate-500 transition hover:border-slate-400 hover:text-slate-700"
    >
        <i class="fa-solid fa-plus"></i>
        関連Traceを追加
    </button>

</x-ui.card>
