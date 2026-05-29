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
        Trace作成
        <i class="fa-solid fa-dog"></i>
    </h1>

    {{-- success --}}
    @if(session('success'))
        <div class="p-4 rounded-xl bg-green-100 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    {{-- error --}}
    @if(session('error'))
        <div class="p-4 rounded-xl bg-red-100 text-red-700">
            {{ session('error') }}
        </div>
    @endif

    <div class="space-y-6">

        {{-- title --}}
        <div class="space-y-2">
            <label class="font-bold">
                タイトル
            </label>

            <input type="text"
                   wire:model="title"
                   class="w-full rounded-xl border border-slate-300 px-4 py-3">

            @error('title')
                <p class="text-sm text-red-500">
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- summary --}}
        <div class="space-y-2">
            <label class="font-bold">
                概要
            </label>

            <textarea wire:model="summary"
                      rows="3"
                      class="w-full rounded-xl border border-slate-300 px-4 py-3"></textarea>

            @error('summary')
                <p class="text-sm text-red-500">
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- status --}}
        <div class="space-y-2">
            <label class="font-bold">
                ステータス
            </label>

            <select wire:model="status"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3">

                @foreach(\App\Models\Trace::statuses() as $value => $label)
                    <option value="{{ $value }}">
                        {{ $label }}
                    </option>
                @endforeach

            </select>

            @error('status')
                <p class="text-sm text-red-500">
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- content --}}
        <div class="space-y-2">
            <label class="font-bold">
                本文
            </label>

            <textarea wire:model="content"
                      rows="15"
                      class="w-full rounded-xl border border-slate-300 px-4 py-3"></textarea>

            @error('content')
                <p class="text-sm text-red-500">
                    {{ $message }}
                </p>
            @enderror
        </div>

        <div class="flex justify-end">
            <button wire:click="save"
                    class="rounded-xl bg-slate-800 px-6 py-3 text-white font-bold hover:bg-slate-700 transition"
            >
                保存する
                <i class="fa-solid fa-dog"></i>
            </button>
        </div>

    </div>

</div>
