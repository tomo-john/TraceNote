<div class="max-w-5xl mx-auto p-6 space-y-6">

    {{-- Header --}}
    <div class="flex items-end justify-between">

        <div class="space-y-4">
            <h1 class="text-3xl font-bold text-slate-700">
                <i class="fa-solid fa-tag"></i>
                Tag一覧
            </h1>

            <p class="text-md text-slate-500">
                Traceを整理するためのタグを作成・管理します。
            </p>
        </div>

        <div class="flex justify-end gap-2">
            <x-ui.button :href="route('trace.index')" variant="secondary" wire:navigate>
                <i class="fa-solid fa-book"></i>
                Trace一覧
            </x-ui.button>
        </div>

    </div>

    <hr class="border-dashed border-slate-200">

    {{-- 新規作成ボタン --}}
    <div class="flex items-center gap-5">
        @if(! $editingId && ! $showForm)
            <x-ui.button variant="primary" type="button" wire:click="openForm">
                <i class="fa-solid fa-plus"></i>
                新規作成
            </x-ui.button>
        @endif
    </div>

    {{-- 作成・編集フォーム --}}
    @if($showForm)

        <x-ui.modal close="closeForm" size="md" :blur="false" persistent>

            <form wire:submit="save" class="space-y-6">

                <div class="border-b border-slate-200 pb-4">
                    <h2 class="text-lg font-bold text-slate-700 flex items-center gap-2">
                        <i class="fa-solid fa-tag"></i>
                        {{ $editingId ? 'タグを編集' : 'タグを作成' }}
                    </h2>

                    <p class="text-sm text-slate-500 mt-1">
                        Traceを整理するためのタグです。
                    </p>
                </div>

                <div class="flex flex-col gap-2">
                    <label for="name"class="text-sm font-semibold text-slate-700">タグ名</label>

                    <x-ui.input
                        wire:model.live="name"
                        id="name"
                        name="name"
                        placeholder="Laravel"
                        autofocus
                    />

                    <x-ui.error name="name" />
                </div>

                <div class="flex flex-col gap-2">
                    <p class="text-sm font-semibold text-slate-700">カラー</p>

                    <div class="flex flex-wrap gap-4">
                        @foreach($this->colorClasses as $key => $class)
                            <button wire:click="$set('color', '{{ $key }}')"
                                    type="button"
                                    class="w-8 h-8 rounded-full transition duration-200 cursor-pointer hover:scale-105 {{ $class }}
                                           {{ $color == $key ? 'ring-2 ring-offset-2 ring-slate-500 scale-110' : ''}}"
                            ></button>
                        @endforeach
                    </div>
                </div>

                <div class="flex flex-col gap-2">
                    <p class="text-sm font-semibold text-slate-700">プレビュー</p>

                    <div class="rounded-2xl bg-slate-50 border border-slate-200 p-5">

                        <div class="flex items-center justify-center gap-2">
                            <span class="px-3 py-1 rounded-full {{ $this->previewClass }}">
                                {{ $name ?: 'Sample Tag'}}
                            </span>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end gap-3 pt-2">
                    <x-ui.button type="submit">

                        <i class="fa-solid {{ $editingId
                            ? 'fa-arrow-rotate-right'
                            : 'fa-plus' }}"></i>

                        {{ $editingId ? '更新' : '作成' }}

                    </x-ui.button>

                    <x-ui.button type="button" variant="secondary" wire:click="closeForm">
                        <i class="fa-solid fa-circle-xmark"></i>
                        キャンセル
                    </x-ui.button>
                </div>

            </form>

        </x-ui.modal>
    @endif

    {{-- タグ一覧 --}}
    <div class="space-y-3">

        <div class="flex items-center gap-2 text-xs font-bold text-slate-400 uppercase tracking-wider">
            <i class="fa-solid fa-tags"></i>
            登録されたタグ一覧
            ({{ $this->tags->count() }} tags)
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @forelse($this->tags as $tag)

                <x-tag.card :tag="$tag" />

            @empty

                <div class="col-span-full">
                    <x-ui.empty-state
                        icon="fa-solid fa-tag"
                        title="まだ登録されたタグがありません"
                        description="最初のタグを作ってみましょう"
                    >
                        <x-ui.button type="button" variant="secondary" wire:click="openForm()">
                            作ってみる
                        </x-ui.button>
                    </x-ui.empty-state>
                </div>

            @endforelse
        </div>

    </div>

</div>
