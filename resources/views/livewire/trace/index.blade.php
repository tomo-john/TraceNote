<div class="max-w-4xl mx-auto p-6 space-y-6">
    <div class="flex items-center justify-center gap-2">
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

    <div class="space-y-3">
        @foreach($traces as $trace)
            <div class="flex items-center justify-between p-4 bg-white rounded-lg shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="flex-1 min-w-0 pr-4">
                    <div class="flex items-center space-x-2">
                        <a href="#" class="text-lg font-bold text-gray-900 hover:text-blue-600 truncate">
                            {{ $trace->title }}
                        </a>
                    </div>
                    <p class="mt-1 text-sm text-gray-500 truncate">
                        {{ $trace->summary }}
                    </p>
                </div>

                <div class="flex items-center space-x-4 flex-shrink-0">
                    <span class="px-2.5 py-1 text-xs font-medium rounded-full bg-blue-50 text-blue-700">
                        {{ $trace->statusLabel() }}
                    </span>
                    <span class="text-xs text-gray-400">
                        {{ $trace->updated_at->format('Y/m/d') }}
                    </span>
                </div>
            </div>
        @endforeach
    </div>

</div>
