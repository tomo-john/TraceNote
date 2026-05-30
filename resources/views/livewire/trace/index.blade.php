<div class="max-w-4xl mx-auto p-6 space-y-6">

    <div class="flex items-center justify-between">
        <div class="flex flex-col">
            <h1 class="text-3xl font-bold text-slate-800">
                Trace一覧
                <i class="fa-solid fa-dog"></i>
            </h1>

            <p class="text-sm text-slate-500">
                {{ $traces->count() }} traces
            </p>
        </div>

        <a href="{{ route('trace.create') }}"
           wire:navigate
           class="inline-block w-28 text-center bg-slate-400 text-white rounded-lg py-2 px-5 hover:bg-slate-500 transition"
        >
            Create
        </a>
    </div>

    @if (session()->has('success'))
        <div class="mb-4 p-4 bg-green-50 border border-green-200 text-green-700 rounded-xl flex items-center space-x-2 font-bold">
            <i class="fa-solid fa-circle-check"></i>
            <span>{{ session('success') }}</span>
        </div>
    @endif

    <div class="space-y-3">
        @forelse($traces as $trace)
            <div class="flex items-center justify-between p-4 bg-white rounded-lg shadow-sm border border-gray-100 hover:shadow-md transition">
                <div class="flex-1 min-w-0 pr-4">
                    <div class="flex items-center space-x-2">
                        <a href="{{ route('trace.show', $trace) }}" class="text-lg font-bold text-gray-900 hover:text-blue-600 truncate">
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
        @empty
            <p class="text-sm text-slte-500">
                まだTraceがありません。<br>
                最初の学びを記録してみましょう。
            </p>
        @endforelse
    </div>

</div>
