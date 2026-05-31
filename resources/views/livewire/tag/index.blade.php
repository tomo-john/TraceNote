<div x-data="tag()"
     class="max-w-4xl mx-auto p-6 space-y-6"
>

    <div class="flex items-center justify-between">
        <div class="flex flex-col">
            <h1 class="text-3xl font-bold text-slate-800">
                Tags
                <i class="fa-solid fa-dog"></i>
            </h1>

            <p class="text-sm text-slate-500">
                {{ $tags->count() }} tags
            </p>
        </div>
    </div>

    @if (session()->has('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center space-x-2 font-bold">
            <i class="fa-solid fa-circle-check"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="flex items-center justify-center gap-5">
        <button @click="show = !show"
                class="bg-slate-200 border rounded-xl p-2 cursor-pointer"
        >
            <i class="fa-solid fa-plus"></i>
            新規作成
        </button>
    </div>
    <div x-show="show"
         class="bg-white border border-slate-200 rounded-2xl p-4"
    >
        <div class="space-y-2">
            <label class="font-bold">タグ名</label>
            <div class="flex items-center gap-2">
                <input type="text"
                       wire:model.defer="name"
                       class="w-56 rounded-xl border border-slate-300 px-4 py-3">

                <button wire:click="save"
                        class="bg-slate-200 border rounded-xl p-2 cursor-pointer"
                >
                    <i class="fa-solid fa-plus"></i>
                    作成
                </button>
            </div>
            @error('name')
                <p class="text-sm text-red-500">
                    {{ $message }}
                </p>
            @enderror
        </div>
    </div>

    <div class="space-y-3">
        @forelse($tags as $tag)
            <div class="flex items-center justify-between p-4 bg-white rounded-lg shadow-sm border border-gray-100 hover:shadow-md transition">
                {{ $tag->name }}
                <div class="flex items-center gap-2">
                    <button wire:click="delete({{ $tag->id }})"
                            wire:confirm="タグを削除しますか？"
                            class="cursor-pointer text-red-500"
                    >
                        <i class="fa-solid fa-trash-can"></i>
                    </button>
                </div>
            </div>
        @empty
            <p class="text-sm text-slte-500">
                まだ登録されたタグがありません。
            </p>
        @endforelse
    </div>

</div>

<script>
    function tag() {
        return {
            show: false,
        }
    }
</script>
