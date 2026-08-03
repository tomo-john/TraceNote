<div class="max-w-5xl mx-auto p-6 space-y-6">

    {{-- Header --}}
    <div class="flex items-end justify-between">

        <div class="space-y-4">
            <h1 class="text-3xl font-bold text-slate-700">
                <i class="fa-solid fa-book-open"></i>
                Trace詳細
            </h1>

            <p class="text-md text-slate-500">
                学習した内容を確認します。
            </p>
        </div>

        <div class="flex justify-end gap-2">
            <x-ui.button :href="route('trace.index')" variant="primary" wire:navigate>
                <i class="fa-solid fa-arrow-left"></i>
                Trace一覧へ戻る
            </x-ui.button>
            <x-ui.button :href="route('trace.edit', $trace)" variant="secondary" wire:navigate>
                <i class="fa-solid fa-pen"></i>
                編集
            </x-ui.button>
            <x-ui.button variant="danger" wire:click="delete" wire:confirm="本当に削除しますか？">
                <i class="fa-solid fa-trash-can"></i>
                削除
            </x-ui.button>
        </div>

    </div>

    <hr class="border-dashed border-slate-200">

    <x-ui.card class="space-y-6">

        {{-- title --}}
        <p class="text-2xl font-bold text-slate-800 leading-tight">{{ $trace->title }}</p>

        {{-- status --}}
        <div class="flex items-center gap-2">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                ステータス
            </p>
            <x-ui.status-badge :status="$trace->status" />
        </div>

        {{-- summary --}}
        <div class="space-y-1 rounded-xl bg-slate-50 p-4">
            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">概要</p>
            <p class="text-slate-600">{{ $trace->summary }}</p>
        </div>

        <div class="flex flex-wrap items-center gap-6">
            {{-- tags --}}
            <div class="flex items-center gap-2">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                    タグ
                </p>
                <div class="flex flex-wrap gap-2">
                    @forelse($trace->tags as $tag)
                        <x-ui.tag-badge :tag="$tag" />
                    @empty
                        <span class="rounded-full px-3 py-1 text-xs font-medium bg-slate-100 text-slate-700">
                            <i class="fa-solid fa-tag"></i>
                            No tags
                        </span>
                    @endforelse
                </div>
            </div>

            {{-- timestamp --}}
            <div class="flex items-center gap-2">
                <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                    更新日
                    <i class="fa-regular fa-clock"></i>
                    {{ $trace->updated_at->format('Y/m/d H:i') }}
                </p>
            </div>
        </div>

    </x-ui.card>

    <x-ui.card class="space-y-5">
        {{-- content --}}
        <div class="border-b border-slate-200 pb-3">
            <p class="font-bold text-slate-700 flex items-center gap-2">
                <i class="fa-solid fa-file-lines"></i>
                本文
            </p>
        </div>
        <p class="whitespace-pre-wrap leading-8 text-slate-700">{{ $trace->content }}</p>
    </x-ui.card>

    {{-- Relation Traces --}}
    <div class="grid grid-cols-3 gap-3">

        @include('livewire.trace.partials.relation-card', [
            'traces' => $this->prerequisiteTraces,
            'relationType' => App\Enums\TraceRelationType::PREREQUISITE,
        ])

        @include('livewire.trace.partials.relation-card', [
            'traces' => $this->childTraces,
            'relationType' => App\Enums\TraceRelationType::CHILD,
        ])

        @include('livewire.trace.partials.relation-card', [
            'traces' => $this->relatedTraces,
            'relationType' => App\Enums\TraceRelationType::RELATED,
        ])

    </div>

    @include('livewire.trace.partials.available-relation-card')

</div>
