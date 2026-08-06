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
            <label for="" class="text-sm font-semibold text-slate-700">タグ</label>

            <div class="flex flex-wrap gap-2">

                @foreach($tags as $tag)

                    <label class="flex items-center gap-1 cursor-pointer">

                        <input
                            type="checkbox"
                            value="{{ $tag->id }}"
                            wire:model.live="selectedTags"
                            class="hidden"
                        >

                        <x-ui.tag-badge :tag="$tag" class="inline-flex transition hover:scale-105
                                                           {{ in_array($tag->id, $selectedTags)
                                                               ? 'ring-2 ring-slate-500 ring-offset-1'
                                                               : ''
                                                           }}"
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

        <div class="flex justify-end">
            <x-ui.button wire:click="save" varitant="secondary">
                <i class="fa-solid fa-dog"></i>
                保存する
            </x-ui.button>
        </div>

    </x-ui.card>

</div>
