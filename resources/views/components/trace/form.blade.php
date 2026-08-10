@props([
    'statuses',
    'tags',
    'selectedTags',
])

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
    <label for="status" class="text-sm font-semibold text-slate-700">ステータス</label>
    <x-ui.select
        id="status"
        wire:model="status"
    >

        @foreach($statuses as $status)
            <option value="{{ $status['value'] }}">
                {{ $status['label'] }}
            </option>
        @endforeach

    </x-ui.select>

    <x-ui.error name="status" />
</div>

{{-- Tags --}}
<div class="space-y-2">
    <p class="text-sm font-semibold text-slate-700">タグ</p>

    <div class="flex flex-wrap gap-2">

        @foreach($tags as $tag)

            <label class="flex items-center gap-1 cursor-pointer">

                <input
                    type="checkbox"
                    value="{{ $tag->id }}"
                    wire:model.live="selectedTags"
                    class="sr-only"
                >

                <x-ui.tag-badge :tag="$tag"
                                @class([
                                    'inline-flex transition hover:scale-105',
                                    'ring-2 ring-slate-500 ring-offset-1 shadow-sm' => in_array($tag->id, $selectedTags),
                                ])
                />

            </label>

        @endforeach

    </div>
</div>

{{-- content --}}
<div class="space-y-2">
    <label for="content" class="text-sm font-semibold text-slate-700">本文</label>
    <x-ui.textarea
        id="content"
        name="content"
        wire:model="content"
        rows="15"
    />

    <x-ui.error name="content" />
</div>

{{-- button --}}
<div class="flex justify-end">
    <x-ui.button wire:click="save">
        <i class="fa-solid fa-dog"></i>
        保存する
    </x-ui.button>
</div>
