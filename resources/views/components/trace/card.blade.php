@props([
    'trace',
])

<a href="{{ route('trace.show', $trace )}}" wire:navigate>

    <x-ui.card class="relative group hover:-translate-y-1">

        {{-- ステータス --}}
        <span class="absolute top-4 right-4 px-3 py-1 text-xs font-medium rounded-full whitespace-nowrap {{ $trace->status->colorClass() }}">
            <i class="{{ $trace->status->iconClass() }}"></i>
            {{ $trace->status->label() }}
        </span>

        <div class="flex items-start justify-between gap-4">

            <div class="min-w-0 space-y-3">
                {{-- タイトル --}}
                <h2 class="text-lg font-bold text-slate-800 group-hover:text-slate-600 line-clamp-1 pr-20">
                    {{ str($trace->title)->limit(20) }}
                </h2>

                {{-- 概要 --}}
                <p class="text-sm text-slate-500 line-clamp-1">
                    {{ $trace->summary }}
                </p>

                {{-- タグ --}}
                <div class="flex flex-wrap gap-2">
                    @forelse($trace->tags as $tag)
                        <span class="px-2 py-1 text-xs rounded-full bg-slate-100 text-slate-600">
                            {{ $tag->name }}
                        </span>
                    @empty
                        <span class="px-2 py-1 text-xs rounded-full bg-slate-500 text-white">
                            No tags
                        </span>
                    @endforelse
                </div>
            </div>

        </div>

        {{-- フッター --}}
        <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between">

            <span class="text-xs text-slate-400">
                {{ $trace->updated_at->format('Y/m/d') }}
            </span>

            <div class="text-sm text-slate-400 group-hover:text-slate-600 transition">
                <i class="fa-solid fa-dog"></i>
            </div>

        </div>

    </x-ui.card>
</a>
