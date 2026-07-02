<div class="max-w-4xl mx-auto p-6 space-y-6">

    <div class="flex items-center justify-center">
        <a href="{{ route('trace.index') }}"
           wire:navigate
           class="inline-block w-28 text-center bg-pink-400 text-white rounded-lg py-2 px-5 hover:bg-amber-500 transition"
        >
            Index
        </a>
    </div>

    <h1 class="text-3xl font-bold">
        Trace詳細
        <i class="fa-solid fa-dog"></i>
    </h1>

    <div class="flex items-center justify-center gap-6">
        <a href="{{ route('trace.edit', $trace) }}"
           wire:navigate
           class="inline-block w-28 text-center bg-green-500 text-white rounded-lg py-2 px-5 hover:bg-green-600 transition"
        >
            <i class="fa-solid fa-pen mx-1"></i>
            編集
        </a>
        <button wire:click="delete"
                wire:confirm="本当に削除しますか？"
                class="inline-block w-28 text-center bg-red-500 text-white rounded-lg py-2 px-5 hover:bg-red-600 transition"
        >
            <i class="fa-solid fa-trash-can mx-1"></i>
            削除
        </button>
    </div>

    <div class="space-y-6">

        {{-- title --}}
        <div class="space-y-2">
            <label class="font-bold">タイトル</label>
            <h1 class="w-full rounded-xl border border-slate-300 px-4 py-3 bg-white break-words">{{ $trace->title }}</h1>
        </div>

        {{-- summary --}}
        <div class="space-y-2">
            <label class="font-bold">概要</label>
            <p class="w-full rounded-xl border border-slate-300 px-4 py-3 bg-white break-words whitespace-pre-wrap">{{ $trace->summary }}</p>
        </div>

        {{-- status --}}
        <div class="space-y-2">
            <label class="font-bold">ステータス</label>
            <div>
                <span class="border rounded-lg px-2 py-1 {{ $trace->status->colorClass() }}">{{ $trace->status->label() }}</span>
            </div>
        </div>

        {{-- tags --}}
        <div class="space-y-2">
            <label class="font-bold">タグ</label>
            <div class="flex items-center gap-2">
                @foreach($trace->tags as $tag)
                    <span class="border bg-sky-200 rounded-lg px-2 py-1">{{ $tag->name }}</span>
                @endforeach
            </div>
        </div>

        {{-- content --}}
        <div class="space-y-2">
            <label class="font-bold">本文</label>
            <p class="w-full rounded-xl border border-slate-300 px-4 py-3 bg-white break-words whitespace-pre-wrap">{{ $trace->content }}</p>
        </div>
    </div>

    {{-- Relation Traces --}}
    <div class="grid grid-cols-3 gap-3">
        <div class="rounded-xl border p-4">

            <label class="font-bold">
                <i class="fa-solid fa-dog"></i>
                前提知識
            </label>

            @forelse($this->prerequisiteTraces as $prerequisiteTrace)
                <div class="flex flex-col gap-2">
                    <div class="flex items-center gap-2">
                        <a href="{{ route('trace.show', $prerequisiteTrace) }}" wire:navigate>
                            <span class="text-sm text-slate-500">
                                {{ $prerequisiteTrace->title }}
                            </span>
                        </a>
                        <button wire:click="" wire:confirm="関連付けを解除しますか？">
                            <span class="text-xs text-red-400">
                                <i class="fa-solid fa-trash-can"></i>
                            </span>
                        </button>
                    </div>
                </div>
            @empty
                <p class="text-sm text-slate-500">登録された前提知識はありません</p>
            @endforelse

            <button wire:click="openAddRelationModal('prerequisite')" class="text-sm text-sky-300">
                <i class="fa-solid fa-plus mr-1"></i>
                追加
            </button>

            {{-- Modal --}}
            @if($showAddRelationModal)
                <div class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
                    <div class="bg-white rounded-xl p-6 w-full max-w-lg max-h-[70vh] overflow-y-auto">
                        <p class="text-sm text-slate-500 text-center">{{ $relationType->label() }}として追加するTraceを選択</p>
                        <div class="space-y-1">
                            @forelse($this->availableRelationTraces as $availableRelationTrace)
                                <div class="grid grid-cols-2">
                                    <div class="text-sm text-slate-500">
                                        #
                                        {{ $availableRelationTrace->id }}
                                        {{ $availableRelationTrace->title }}
                                    </div>
                                    <button wire:click="addPrerequisite({{ $availableRelationTrace }})" class="">
                                        <span class="text-sm text-sky-500">
                                            <i class="fa-solid fa-plus mr-1"></i>追加
                                        </span>
                                    </button>
                                </div>
                            @empty
                                <p class="text-sm text-slate-500">関連付けすることのできるTraceがありません</p>
                            @endforelse
                            <div class="flex items-center justify-center">
                                <button wire:click="closeAddRelationModal" class="cursor-pointer border bg-gray-400 rounded-xl px-2 py-1">
                                    <span class="text-xs">閉じる</span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            @endif

        </div>

        <div class="rounded-xl border p-4">
            <label class="font-bold">
                <i class="fa-solid fa-dog"></i>
                子知識
            </label>
            @forelse($this->childTraces as $childTrace)
                <div class="flex flex-col gap-2">
                    <a href="{{ route('trace.show', $childTrace) }}" wire:navigate>
                        <span class="text-sm text-slate-500">
                            {{ $childTrace->title }}
                        </span>
                    </a>
                </div>
            @empty
                <p class="text-sm text-slate-500">登録された子知識はありません</p>
            @endforelse
        </div>

        <div class="rounded-xl border p-4">
            <label class="font-bold">
                <i class="fa-solid fa-dog"></i>
                関連知識
            </label>
            @forelse($this->relatedTraces as $relatedTrace)
                <div class="flex flex-col gap-2">
                    <a href="{{ route('trace.show', $relatedTrace) }}" wire:navigate>
                        <span class="text-sm text-slate-500">
                            {{ $relatedTrace->title }}
                        </span>
                    </a>
                </div>
            @empty
                <p class="text-sm text-slate-500">登録された関連知識はありません</p>
            @endforelse
        </div>
    </div>

    {{-- 検証中 --}}
    <div class="rounded-xl border p-4">
        <label class="font-bold">
            <i class="fa-solid fa-dog"></i>
            関連付けすることのできるTrace
        </label>
        @forelse($this->availableRelationTraces as $availableRelationTrace)
            <div class="flex flex-col gap-2">
                <a href="{{ route('trace.show', $availableRelationTrace) }}" wire:navigate>
                    <div class="text-sm text-slate-500">
                        #
                        {{ $availableRelationTrace->id }}
                        {{ $availableRelationTrace->title }}
                    </div>
                </a>
            </div>
        @empty
            <p class="text-sm text-slate-500">関連付けすることのできるTraceがありません</p>
        @endforelse
    </div>
</div>
