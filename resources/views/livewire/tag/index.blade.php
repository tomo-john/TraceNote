<div class="max-w-5xl mx-auto p-6 space-y-6">

    {{-- Header --}}
    <div class="flex items-end justify-between">

        <div class="space-y-4">
            <h1 class="text-3xl font-bold text-slate-700">
                <i class="fa-solid fa-tags"></i>
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
            <x-ui.button variant="primary" button wire:click="openForm">
                <i class="fa-solid fa-plus"></i>
                新規作成
            </x-ui.button>
        @endif
    </div>

    {{-- 作成・編集フォーム --}}
    @if($showForm)
        <x-ui.card class="max-w-xl mx-auto space-y-4">

            <div class="border-b border-slate-200 pb-4">
                <h2 class="text-lg font-bold text-slate-700 flex items-center gap-2">
                    <i class="fa-solid fa-tag"></i>
                    {{ $editingId ? 'タグを編集' : 'タグを作成' }}
                </h2>

                <p class="text-sm text-slate-500 mt-1">
                    Traceを整理するためのタグです。
                </p>
            </div>


            <div>
                <label for="name"class="text-sm font-semibold text-slate-700">タグ名</label>

                <x-ui.input
                    wire:model.live="name"
                    id="name"
                    name="name"
                    placeholder="Laravel"
                />

                <x-ui.error name="name" />
            </div>

            <div>
                <label for="color" class="text-sm font-semibold text-slate-700">カラー</label>

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

            <div>
                <label for="preview" class="text-sm font-semibold text-slate-700">プレビュー</label>

                <div class="rounded-2xl bg-slate-50 border border-slate-200 p-5">

                    <div class="flex items-center justify-center gap-2">
                        <i class="fa-solid fa-tag w-6 h-6 rounded-full p-1 {{ $this->previewClass }}"></i>
                        <span class="px-3 py-1 rounded-full {{ $this->previewClass }}">
                            {{ $name ?: 'Sample Tag'}}
                        </span>
                    </div>
                </div>
            </div>

            <div class="flex justify-end gap-3 pt-2">
                <x-ui.button type="button" wire:click="save">

                    <i class="fa-solid {{ $editingId
                        ? 'fa-arrow-rotate-right'
                        : 'fa-plus' }}"></i>

                    {{ $editingId ? '更新' : '作成' }}

                </x-ui.button>

                <x-ui.button variant="secondary" wire:click="closeForm">
                    <i class="fa-solid fa-circle-xmark"></i>
                    キャンセル
                </x-ui.button>
            </div>

        </x-ui.card>
    @endif

    {{-- タグ一覧 --}}
    <div class="flex flex-wrap gap-3 w-full">
        @forelse($tags as $tag)

            <div class="group flex items-center justify-between gap-2 p-4 rounded-lg shadow-sm hover:shadow-md transition
                        {{ $editingId === $tag->id ? 'bg-pink-50 border-pink-200' : 'bg-white border-gray-200' }}">

                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-tag text-slate-400"></i>
                    <span class="px-3 py-1 rounded-full text-sm font-medium {{ $tag->colorClass() }}">
                        {{ $tag->name }}
                    </span>
                </div>

                <div class="flex items-center gap-2 opacity-0 group-hover:opacity-100 transition-all duration-300">
                    <button wire:click="edit({{ $tag->id }})"
                            class="cursor-pointer text-blue-400 hover:text-blue-500 cursor-pointer"
                    >
                        <i class="fa-solid fa-pen"></i>
                    </button>
                    <button wire:click="delete({{ $tag->id }})"
                            wire:confirm="タグを削除しますか？"
                            class="cursor-pointer text-red-400 hover:text-red-500 cursor-pointer"
                    >
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </div>

            </div>
        @empty
            <div class="col-span-full bg-white rounded-2xl border border-slate-200 p-8 text-center">
                <p class="text-slate-500">
                    まだ登録されたタグがありません。<br>
                    最初のタグを作ってみましょう
                    <i class="fa-solid fa-dog"></i>
                </p>
            </div>
        @endforelse
    </div>

</div>
