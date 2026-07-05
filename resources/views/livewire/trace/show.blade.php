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
        @include('livewire.trace.partials.prerequisite-card')
        @include('livewire.trace.partials.child-card')
        @include('livewire.trace.partials.related-card')
    </div>

    @include('livewire.trace.partials.available-relation-card')

</div>
