<div class="max-w-5xl mx-auto p-6 space-y-6">

    <div class="flex items-center justify-between">
        <div class="flex flex-col">
            <h1 class="text-3xl font-bold text-slate-800">
                Tags
                <i class="fa-solid fa-dog"></i>
            </h1>

            <p class="text-sm text-slate-500">
                {{ $tags->count() }} tags
            </p>
        </div>

        <div class="flex items-center gap-2">
            <a href="{{ route('trace.index') }}"
               wire:navigate
               class="inline-block w-28 text-center bg-slate-400 text-white rounded-lg py-2 px-5 hover:bg-slate-500 transition"
            >
                <i class="fa-solid fa-dog"></i>
                Trace
            </a>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center space-x-2 font-bold">
            <i class="fa-solid fa-circle-check"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    {{-- 新規作成ボタン --}}
    <div class="flex items-center gap-5">
        @if(!$editingId)
            @if($showCreateForm)
                <button wire:click="closeCreateForm"
                        class="bg-slate-200 border rounded-xl p-2 cursor-pointer"
                >
                    <i class="fa-solid fa-xmark"></i>
                    閉じる
                </button>
            @else
                <button wire:click="openCreateForm"
                        class="bg-slate-200 border rounded-xl p-2 cursor-pointer"
                >
                    <i class="fa-solid fa-plus"></i>
                    新規作成
                </button>
            @endif
        @endif
    </div>

    {{-- 新規作成フォーム --}}
    @if($showCreateForm)
        <div class="bg-white border border-slate-200 rounded-2xl p-5 shadow-sm space-y-4">
            <div class="space-y-2">
                <label class="text-sm font-bold text-slate-500">New Tag</label>
                <div class="flex items-center gap-2">
                    {{-- タグ名 --}}
                    <input type="text"
                           wire:model.live="name"
                           class="w-56 rounded-full border px-3 py-1">

                    {{-- 色 --}}
                    @foreach($this->colorClasses as $key => $class)
                        <button wire:click="$set('color', '{{ $key }}')"
                                class="w-8 h-8 rounded-full cursor-pointer {{ $class }}
                                       {{ $color == $key ? 'ring-2 ring-offset-2 ring-slate-400' : ''}}"
                        ></button>
                    @endforeach

                    <button wire:click="save"
                            class="bg-slate-200 border rounded-xl p-2 cursor-pointer"
                    >
                        <i class="fa-solid fa-plus"></i>
                        作成
                    </button>
                </div>

                {{-- プレビュー --}}
                <label class="text-sm font-bold text-slate-500">Preview</label>
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-tag text-slate-400"></i>
                    <span class="px-3 py-1 rounded-full text-sm font-medium {{ $this->previewClass }}">
                        {{ $name ?: 'sample'}}
                    </span>
                </div>

                @error('name')
                    <p class="text-sm text-red-500">
                        {{ $message }}
                    </p>
                @enderror
            </div>
        </div>
    @endif

    {{-- タグ一覧 --}}
    <div class="grid md:grid-cols-2 gap-4">
        @forelse($tags as $tag)

            <div class="group flex items-center justify-between p-4 rounded-lg shadow-sm border hover:shadow-md transition
                        {{ $editingId === $tag->id ? 'bg-pink-50 border-pink-200' : 'bg-white border-gray-200' }}">

                @if($editingId === $tag->id)

                    <div class="flex items-center justify-left gap-2">
                        <input type="text"
                               wire:model="name"
                               class="w-56 rounded-xl border border-pink-300 px-4 py-3"
                        >
                        <button wire:click="save"
                                class="cursor-pointer font-bold text-sm text-pink-500 hover:text-pink-600 transition"
                        >
                            更新
                        </button>
                        <button wire:click="cancelEdit"
                                class="cursor-pointer font-bold text-sm text-slate-500 hover:text-slate-600 transition"
                        >
                            取消
                        </button>
                    </div>

                @else

                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-tag text-slate-400"></i>
                        <span class="px-3 py-1 rounded-full text-sm font-medium {{ $tag->colorClass() }}">
                            {{ $tag->name }}
                        </span>
                    </div>

                @endif

                <div class="flex items-center gap-3 opacity-0 group-hover:opacity-100 transition-all duration-300">
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
