<div class="max-w-4xl mx-auto p-6 space-y-6">

    <div class="flex items-center justify-between">
        <div class="flex flex-col">
            <h1 class="text-3xl font-bold text-slate-800">
                Trace一覧
                <i class="fa-solid fa-dog"></i>
            </h1>

            <p class="text-sm text-slate-500">
                {{ $traces->count() }} traces
            </p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('trace.create') }}"
               wire:navigate
               class="inline-block w-28 text-center bg-slate-400 text-white rounded-lg py-2 px-5 hover:bg-slate-500 transition"
            >
                <i class="fa-solid fa-plus"></i>
                Create
            </a>
            <a href="{{ route('tag.index') }}"
               wire:navigate
               class="inline-flex items-center justify-center gap-1.5 w-28 text-center bg-white border border-slate-200 text-slate-600 rounded-lg py-2 px-5 hover:bg-slate-50 transition"
            >
                <i class="fa-solid fa-tag"></i>
                Tags
            </a>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center space-x-2 font-bold">
            <i class="fa-solid fa-circle-check"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid gap-4 md:grid-cols-2">
        @forelse($traces as $trace)

            <a href="{{ route('trace.show', $trace) }}"
               wire:navigate
               class="relative group bg-white rounded-2xl border border-slate-200 p-5
                      shadow-sm hover:shadow-lg hover:-translate-y-1
                      transition duration-300">

                {{-- ステータス --}}
                <span class="absolute top-4 right-4 px-3 py-1 text-xs font-medium rounded-full bg-slate-100 text-slate-600 whitespace-nowrap">
                    {{ $trace->statusLabel() }}
                </span>

                <div class="flex items-start justify-between gap-4">

                    <div class="min-w-0 space-y-3">
                        {{-- タイトル --}}
                        <h2 class="text-lg font-bold text-slate-800 group-hover:text-slate-600 line-clamp-1 pr-20">
                            {{ $trace->title, 30 }}
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

            </a>

        @empty

            <div class="col-span-full bg-white rounded-2xl border border-slate-200 p-8 text-center">
                <p class="text-slate-500">
                    まだTraceがありません。<br>
                    最初の学びを記録してみましょう。
                </p>
            </div>

        @endforelse
    </div>

</div>
