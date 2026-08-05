<div class="max-w-5xl mx-auto p-6 space-y-6">

    {{-- Header --}}
    <x-trace.page-header
        title="Trace作成"
        description="新しい学びをを記録します。"
        icon="fa-solid fa-file-circle-plus"
    >

        <x-ui.button :href="route('trace.index')" variant="primary" wire:navigate>
            <i class="fa-solid fa-arrow-left"></i>
            Trace一覧へ戻る
        </x-ui.button>

    </x-trace.page-header>

    {{-- Old --}}
    <x-ui.card class="space-y-6">

        {{-- title --}}
        <div class="space-y-2">
            <label for="title" class="text-sm font-semibold text-slate-700">タイトル</label>
            <x-ui.input
                id="title"
                name="title"
                wire:model="title"
            />

            <x-ui.error name="title" />
        </div>

        {{-- summary --}}
        <div class="space-y-2">
            <label for="summary" class="text-sm font-semibold text-slate-700">概要</label>
            <x-ui.textarea
                id="summary"
                name="summary"
                wire:model="summary"
                rows="2"
            />

            <x-ui.error name="summary" />
        </div>

        {{-- status --}}
        <div class="space-y-2">
            <label class="font-bold">ステータス</label>
            <select wire:model="status"
                    class="w-full rounded-xl border border-slate-300 px-4 py-3">

                @foreach($statuses as $status)
                    <option value="{{ $status['value'] }}">
                        {{ $status['label'] }}
                    </option>
                @endforeach

            </select>

            @error('status')
                <p class="text-sm text-red-500">
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Tags --}}
        <div class="space-y-2">
            <label class="font-bold">
                タグ
            </label>

            <div class="flex flex-wrap gap-2">

                @foreach($tags as $tag)
                    <label
                        class="flex items-center gap-1 px-3 py-2 rounded-xl border border-slate-300 cursor-pointer"
                    >
                        <input type="checkbox"
                               value="{{ $tag->id }}"
                               wire:model="selectedTags"
                        >
                        {{ $tag->name }}
                    </label>
                @endforeach

            </div>
        </div>

        {{-- content --}}
        <div class="space-y-2">
            <label class="font-bold">本文</label>
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

    </x-ui.card>

</div>
