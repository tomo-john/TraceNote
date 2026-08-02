@props([
    'tag',
])

<x-ui.card class="hover:-translate-y-1 space-y-6">

    <div>
        <x-ui.tag-badge :tag="$tag" />
    </div>

    <div class="border-t border-slate-200 pt-3 flex items-center justify-between text-slate-400">

        <div class="flex items-center gap-2 text-sm text-slate-500">
            <i class="fa-solid fa-book-open text-xs"></i>
            <span>{{ $tag->traces_count }} Traces</span>
        </div>

        <div class="flex items-center gap-2">
            <button type="button"
                    wire:click="edit({{ $tag->id }})"
                    class="w-8 h-8 rounded-lg hover:bg-sky-50 hover:text-sky-600 transition"
            >
                <i class="fa-solid fa-pen"></i>
            </button>

            <button type="button"
                    wire:click="delete({{ $tag->id }})"
                    wire:confirm="「 {{ $tag->name }} 」タグを削除しますか？"
                    class="w-8 h-8 rounded-lg hover:bg-rose-50 hover:text-rose-600 transition"
            >
                <i class="fa-solid fa-trash"></i>
            </button>
        </div>

    </div>
</x-ui.card>
