<div class="max-w-5xl mx-auto p-6 space-y-6">

    {{-- Header --}}
    <x-trace.page-header
        title="Trace編集"
        description="記録した学びの内容を編集します。"
        icon="fa-solid fa-pen-to-square"
    >

        <x-ui.button :href="route('trace.index')" variant="primary" wire:navigate>
            <i class="fa-solid fa-arrow-left"></i>
            Trace一覧へ戻る
        </x-ui.button>

    </x-trace.page-header>

    <x-ui.card class="space-y-6">

        <x-trace.form
            :statuses="$statuses"
            :tags="$tags"
            :selectedTags="$selectedTags"
        />

    </x-ui.card>

</div>
