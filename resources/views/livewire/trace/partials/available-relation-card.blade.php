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
