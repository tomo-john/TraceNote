<div class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">

    <div class="bg-white rounded-xl p-6 w-full max-w-lg max-h-[70vh] overflow-y-auto">

        <p class="text-sm text-slate-500 text-center">{{ $relationType->label() }}として追加するTraceを選択</p>

        <div class="space-y-1">
            @forelse($this->availableRelationTraces as $availableRelationTrace)
                <div class="grid grid-cols-2">
                    <div class="text-sm text-slate-500">
                        #
                        {{ $availableRelationTrace->id }}
                        {{ $availableRelationTrace->title }}
                    </div>
                    <button wire:click="addRelation({{ $availableRelationTrace }})" class="">
                        <span class="text-sm text-sky-500">
                            <i class="fa-solid fa-plus mr-1"></i>追加
                        </span>
                    </button>
                </div>
            @empty
                <p class="text-sm text-slate-500">関連付けすることのできるTraceがありません</p>
            @endforelse

            <div class="flex items-center justify-center">
                <button wire:click="closeAddRelationModal" class="cursor-pointer border bg-gray-400 rounded-xl px-2 py-1">
                    <span class="text-xs">閉じる</span>
                </button>
            </div>

        </div>

    </div>

</div>
