<div class="max-w-5xl mx-auto p-6 space-y-6">

    {{-- Header --}}
    <x-trace.page-header
        title="Trace一覧"
        icon="fa-solid fa-book"
    >

        <x-slot:description>
            学習した内容を管理します。<br>
            記録・検索・整理ができます。
        </x-slot:description>

        <x-ui.button :href="route('trace.create')" variant="primary" wire:navigate>
            <i class="fa-solid fa-plus"></i>
            新規作成
        </x-ui.button>

        <x-ui.button :href="route('tag.index')" variant="secondary" wire:navigate>
            <i class="fa-solid fa-tag"></i>
            タグ
        </x-ui.button>

    </x-trace.page-header>

    @if($this->totalTraces)

        {{-- フィルターカード --}}
        <x-ui.card class="space-y-4">
            <div class="flex items-center justify-between">
                <h2 class="text-sm font-bold text-slate-700 flex items-center gap-2">
                    <i class="fa-solid fa-filter"></i>
                    絞り込み
                </h2>

                {{-- 検索条件リセット --}}
                <x-ui.button variant="secondary" type="button" wire:click="clearFilters">
                    <i class="fa-solid fa-arrow-rotate-left"></i>
                    検索条件をリセット
                </x-ui.button>
            </div>

            {{-- 検索 --}}
            <div>
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
                    <x-ui.select wire:model.live="status" id="status">
                        <option value="">すべてのステータス</option>
                        @foreach($this->statuses as $status)
                            <option value="{{ $status['value'] }}">{{ $status['label'] }}</option>
                        @endforeach
                    </x-ui.select>
                </div>

                {{-- 並び替え --}}
                <div class="w-full md:w-48">
                    <x-ui.select wire:model.live="sort" id="sort">
                        <option value="latest">新しい順</option>
                        <option value="oldest">古い順</option>
                        <option value="title">タイトル順</option>
                    </x-ui.select>
                </div>

            </div>

            {{-- タグ選択 --}}
            <div class="flex flex-wrap gap-2">
                <button wire:click="$set('selectedTagId', null)"
                        class="rounded-full
                               bg-slate-100
                               px-2 py-1
                               font-medium text-xs text-slate-700
                               transition cursor-pointer
                               hover:scale-105
                               {{ is_null($selectedTagId)
                                   ? 'ring-1 ring-slate-500 ring-offset-1'
                                   : ''
                               }}
                        "
                >
                    ALL
                </button>

                @foreach($this->tags as $tag)
                    <button wire:click="$set('selectedTagId', {{ $tag->id }})"
                            class="rounded-full
                                   px-3 py-1
                                   text-xs font-medium
                                   transition cursor-pointer
                                   hover:scale-105
                                   {{ $tag->colorClass() }}
                                   {{ $selectedTagId === $tag->id
                                       ? 'ring-1 ring-slate-500 ring-offset-1'
                                       : ''
                                   }}
                            "
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
            <i class="fa-solid fa-book"></i>
            登録されたTrace
            ({{ $this->totalTraces }} traces)
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($this->traces as $trace)

                <x-trace.card :trace="$trace" />

            @empty

                @if($this->totalTraces)

                    <div class="col-span-full">
                        <x-ui.empty-state
                            icon="fa-solid fa-search"
                            title="条件に一致するTraceがありません"
                            description="検索条件を変更してみてください"
                        >
                            <x-ui.button type="button" variant="secondary" wire:click="clearFilters">
                                リセット
                            </x-ui.button>
                        </x-ui.empty-state>
                    </div>

                @else

                    <div class="col-span-full">
                        <x-ui.empty-state
                            icon="fa-solid fa-book"
                            title="まだTraceがありません"
                            description="最初の学びを記録してみましょう"
                        >
                            <x-ui.button type="button" variant="secondary" :href="route('trace.create')" wire:navigate>
                                <i class="fa-solid fa-plus"></i>
                                新規作成
                            </x-ui.button>
                        </x-ui.empty-state>
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
