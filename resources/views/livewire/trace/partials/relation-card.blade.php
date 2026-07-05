<div class="rounded-xl border p-4">

    <label class="font-bold">
        <i class="fa-solid fa-dog"></i>
        {{ $title }}
    </label>

    @forelse($traces as $trace)
        <div class="flex flex-col gap-2">
            <div class="flex items-center gap-2">
                <a href="{{ route('trace.show', $trace) }}" wire:navigate>
                    <span class="text-sm text-slate-500">
                        {{ $trace->title }}
                    </span>
                </a>
                <button wire:click="removeRelation({{ $trace }})" wire:confirm="関連付けを解除しますか？">
                    <span class="text-xs text-red-400">
                        <i class="fa-solid fa-trash-can"></i>
                    </span>
                </button>
            </div>
        </div>
    @empty
        <p class="text-sm text-slate-500">登録された{{ $relationType->label() }}はありません</p>
    @endforelse

    <button wire:click="openAddRelationModal('{{ $relationType->value }}')" class="text-sm text-sky-300">
        <i class="fa-solid fa-plus mr-1"></i>
        追加
    </button>

    {{-- Modal --}}
    @if($showAddRelationModal)
        @include('livewire.trace.partials.add-relation-modal')
    @endif

</div>
