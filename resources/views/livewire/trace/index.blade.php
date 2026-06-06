<div class="max-w-5xl mx-auto p-6 space-y-6">

    <div class="flex items-center justify-between">
        <div class="flex flex-col">
            <h1 class="text-3xl font-bold text-slate-800">
                Trace一覧
                <i class="fa-solid fa-dog"></i>
            </h1>
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

    @if($this->totalTraces)

        {{-- 検索・フィルター用ツールバーエリア --}}
        <div class="space-y-3">
            <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-wider">
                <i class="fa-solid fa-filter"></i>
                Filter
            </div>

            <div class="flex flex-col md:flex-row items-stretch md:items-center gap-4 bg-slate-50 p-4 rounded-2xl border border-slate-200 shadow-sm">

                {{-- 検索インプット --}}
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-magnifying-glass text-sm"></i>
                    </div>
                    <input type="text"
                           wire:model.live.debounce.300ms="search"
                           placeholder="タイトルや概要を検索..."
                           class="w-full rounded-xl border border-slate-300 pl-10 pr-4 py-2.5 text-sm bg-white shadow-inner focus:border-pink-400 focus:ring-1 focus:ring-pink-400 placeholder-slate-400"
                    >
                </div>

                {{-- ステータス選択 --}}
                <div class="w-full md:w-56 flex items-center gap-2">
                    <span class="text-xs font-bold text-slate-500 whitespace-nowrap hidden md:inline">Status:</span>
                    <select wire:model.live="status"
                            class="w-full rounded-xl border border-slate-300 bg-white px-3 py-2.5 text-sm text-slate-700 shadow-sm focus:border-pink-400 focus:ring-1 focus:ring-pink-400"
                    >
                        <option value="">すべてのステータス</option>
                        @foreach(\App\Models\Trace::statuses() as $value => $label)
                            <option value="{{ $value }}">{{ $label }}</option>
                        @endforeach
                    </select>
                </div>

            </div>
        </div>

        {{-- Tag選択 --}}
        <div class="space-y-3">

            <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-wider">
                <i class="fa-solid fa-tags"></i>
                Tags
            </div>

            <div class="flex flex items-center gap-2 bg-slate-50 p-2 rounded-2xl border border-slate-200 shadow-sm">
                <button wire:click="$set('selectedTagId', '')"
                        class="inline-block text-center bg-slate-500 text-white text-xs rounded-full py-1 px-2 hover:bg-slate-600 transition cursor-pointer"
                >
                    ALL
                </button>
                @foreach($tags as $tag)
                    <button wire:click="$set('selectedTagId', {{ $tag->id }})"
                            class="inline-block text-center text-xs rounded-full py-1 px-2 hover:bg-slate-400 transition cursor-pointer
                                   {{ $selectedTagId == $tag->id
                                        ? 'bg-pink-300 text-white'
                                        : 'bg-slate-300 text-slate-600'
                                   }}"
                    >
                    {{ $tag->name }}
                    </button>
                @endforeach
            </div>
        </div>

    @endif

    {{-- 一覧表示 --}}
    <div class="space-y-3">
        <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-wider">
            <i class="fa-solid fa-dog"></i>
            Traces
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($this->traces as $trace)

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

                </a>

            @empty

                @if($this->totalTraces)

                    <div class="col-span-full bg-white rounded-2xl border border-slate-200 p-8 text-center">
                        <p class="text-slate-500">
                            条件に一致するTraceがありません
                            <i class="fa-solid fa-dog"></i>
                        </p>
                        <button wire:click="clearFilters"
                                class="inline-block text-center bg-slate-400 text-white rounded-lg py-2 px-5 m-6 hover:bg-slate-500 transition"
                        >
                            リセット
                        </button>
                    </div>

                @else

                    <div class="col-span-full bg-white rounded-2xl border border-slate-200 p-8 text-center">
                        <p class="text-slate-500">
                            まだTraceがありません。<br>
                            最初の学びを記録してみましょう
                            <i class="fa-solid fa-dog"></i>
                        </p>
                    </div>

                @endif

            @endforelse
        </div>
    </div>

    {{-- ページネーション --}}
    <div class="mt-8">
        {{ $this->traces->links() }}
    </div>
</div>
