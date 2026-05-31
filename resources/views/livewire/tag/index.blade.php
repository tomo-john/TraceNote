<div class="max-w-4xl mx-auto p-6 space-y-6">

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

    <div class="space-y-3">
        @forelse($tags as $tag)
            <div class="flex items-center justify-between p-4 bg-white rounded-lg shadow-sm border border-gray-100 hover:shadow-md transition">
            </div>
        @empty
            <p class="text-sm text-slte-500">
                No Tags.
            </p>
        @endforelse
    </div>

</div>
