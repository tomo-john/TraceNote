<div class="max-w-4xl mx-auto p-6 space-y-6">
    <div class="flex items-center justify-center">
        <i class="fa-solid fa-dog"></i>
        {{ $traces->count() }}
    </div>

    <div class="flex items-center justify-center gap-4">
        <a href="{{ route('trace.create') }}"
           class="inline-block w-28 text-center bg-pink-400 text-white rounded-lg py-2 px-5 hover:bg-amber-500 transition"
        >
            Create
        </a>
        <a href="{{ route('dashboard') }}"
           class="inline-block w-28 text-center bg-pink-400 text-white rounded-lg py-2 px-5 hover:bg-amber-500 transition"
        >
            Dashboard
        </a>
    </div>

</div>
