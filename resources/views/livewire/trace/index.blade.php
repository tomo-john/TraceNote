<div class="max-w-5xl mx-auto p-6 space-y-6">

    {{-- Header --}}
    <div class="flex items-end justify-between">

        <div class="space-y-4">
            <h1 class="text-3xl font-bold text-slate-700">
                <i class="fa-solid fa-book"></i>
                Trace一覧
            </h1>

            <p class="text-md text-slate-500">
                学習した内容を管理します。<br>
                記録・検索・整理ができます。
            </p>
        </div>

        <div class="flex justify-end gap-2">
            <x-ui.button :href="route('trace.create')" variant="primary" wire:navigate>
                <i class="fa-solid fa-plus"></i>
                新規作成
            </x-ui.button>
            <x-ui.button :href="route('tag.index')" variant="secondary" wire:navigate>
                <i class="fa-solid fa-tag"></i>
                タグ
            </x-ui.button>
        </div>

    </div>

    <hr class="border-dashed border-slate-200">

    @if($this->totalTraces)

        {{-- フィルターカード --}}
        <x-ui.card class="space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-bold text-slate-700 flex items-center gap-2">
                    <i class="fa-solid fa-filter"></i>
                    絞り込み
                </h2>

                {{-- 検索条件リセット --}}
                <x-ui.button variant="ghost" type="button" wire:click="clearFilters">
                    <i class="fa-solid fa-arrow-rotate-left"></i>
                    検索条件をリセット
                </x-ui.button>
            </div>

            {{-- 検索 --}}
            <div>
                <label for="search" class="text-sm font-semibold text-slate-700">検索</label>

                <x-ui.input
                    wire:model.live.debounce.300ms="search"
                    id="search"
                    name="search"
                    type="text"
                    placeholder="タイトルや概要を検索..."
                />
            </div>

            <div class="flex items-center gap-4">
                {{-- ステータス --}}
                <div class="w-full md:w-48">
                    <label for="status" class="text-sm font-semibold text-slate-700">ステータス</label>
                    <x-ui.select wire:model.live="status" id="status">
                        <option value="">すべてのステータス</option>
                        @foreach($statuses as $status)
                            <option value="{{ $status['value'] }}">{{ $status['label'] }}</option>
                        @endforeach
                    </x-ui.select>
                </div>

                {{-- 並び替え --}}
                <div class="w-full md:w-48">
                    <label for="sort" class="text-sm font-semibold text-slate-700">並び替え</label>
                    <x-ui.select wire:model.live="sort" id="sort">
                        <option value="latest">新しい順</option>
                        <option value="oldest">古い順</option>
                        <option value="title">タイトル順</option>
                    </x-ui.select>
                </div>

            </div>
        </x-ui.card>

        {{-- タグ選択 --}}
        <x-ui.card>
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-bold text-slate-700 flex items-center gap-2">
                    <i class="fa-solid fa-tags"></i>
                    タグ選択
                </h2>

                {{-- タグ選択リセット --}}
                <x-ui.button variant="ghost" type="button" wire:click="clearFilters">
                    <i class="fa-solid fa-arrow-rotate-left"></i>
                    タグ選択をリセット
                </x-ui.button>
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
        </x-ui.card>

    @endif

    {{-- 一覧表示 --}}
    <div class="space-y-3">
        <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-wider">
            <i class="fa-solid fa-dog"></i>
            Traces
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($this->traces as $trace)
                <x-trace.card :trace="$trace" />
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
