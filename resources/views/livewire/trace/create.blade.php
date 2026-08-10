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

        <x-trace.form
            :statuses="$statuses"
            :tags="$tags"
            :selectedTags="$selectedTags"
        />

    </x-ui.card>

</div>
