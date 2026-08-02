@props([
    'trace',
])

<a href="{{ route('trace.show', $trace )}}" wire:navigate>

    <x-ui.card class="relative group hover:-translate-y-1">

        <div class="flex items-start justify-between gap-4">

            <div class="min-w-0 space-y-3">
                {{-- タイトル --}}
                <h2 class="text-lg font-bold text-slate-800 group-hover:text-slate-600 line-clamp-1">
                    {{ $trace->title }}
                </h2>

                {{-- 概要 --}}
                <p class="text-sm text-slate-500 line-clamp-1">
                    {{ $trace->summary }}
                </p>

                {{-- タグ --}}
                <div class="flex flex-wrap gap-2">
                    @forelse($trace->tags as $tag)
                        <span class="px-2 py-1 text-xs rounded-full {{ $tag->colorClass() }}">
                            {{ $tag->name }}
                        </span>
                    @empty
                        <span class="px-2 py-1 text-xs rounded-full bg-slate-100 text-slate-700">
                            <i class="fa-solid fa-tag"></i>
                            No tags
                        </span>
                    @endforelse
                </div>
            </div>

        </div>

        <div class="mt-5 pt-4 border-t border-slate-100 flex items-center justify-between">

            {{-- ステータス --}}
            <span class="px-3 py-1 text-xs font-medium rounded-full whitespace-nowrap {{ $trace->status->colorClass() }}">
                <i class="{{ $trace->status->iconClass() }}"></i>
                {{ $trace->status->label() }}
            </span>

            {{-- 日付 --}}
            <span class="text-xs text-slate-400">
                {{ $trace->created_at->format('Y/m/d') }}
            </span>

        </div>

    </x-ui.card>
</a>
