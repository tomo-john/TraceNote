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

    @if (session()->has('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center space-x-2 font-bold">
            <i class="fa-solid fa-circle-check"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

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
            <p class="w-full rounded-xl border border-slate-300 px-4 py-3 bg-white">{{ $trace->statusLabel() }}</p>
        </div>

        {{-- content --}}
        <div class="space-y-2">
            <label class="font-bold">本文</label>
            <p class="w-full rounded-xl border border-slate-300 px-4 py-3 bg-white break-words whitespace-pre-wrap">{{ $trace->content }}</p>
        </div>
    </div>
</div>
