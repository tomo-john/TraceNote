<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">

            {{-- Trace Count --}}
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 flex items-center justify-center gap-2">
                <a href="{{ route('trace.index') }}">
                    <i class="fa-solid fa-dog text-sky-400"></i>
                    <span>{{ $traceCount }} Traces</span>
                </a>
            </div>

            {{-- Tag Count --}}
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 flex items-center justify-center gap-2">
                <a href="{{ route('tag.index') }}">
                    <i class="fa-solid fa-tag text-sky-400"></i>
                    <span>{{ $tagCount }} Tags</span>
                </a>
            </div>

            {{-- Status Counts --}}
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 flex items-center justify-center gap-2">
                <div class="flex items-center justify-center gap-2">
                    <div class="grid grid-cols-2 gap-6">
                        @foreach($statusCounts as $status)
                            <div class="flex items-center gap-1 px-1 py-2 rounded-2xl {{ $status['colorClass'] }}">
                                <i class="{{ $status['iconClass'] }}"></i>
                                <span class="">{{ $status['label'] }}: {{ $status['count'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>

        <div class="relative h-full rounded-xl border border-neutral-200 dark:border-neutral-700">
            <div class="rounded-xl p-6">

                <h2 class="font-bold text-lg mb-4">
                    最近のTrace
                </h2>

                <div class="space-y-3">

                    @forelse ($recentTraces as $trace)

                        <a href="{{ route('trace.show', $trace) }}"
                           class="block rounded-lg border border-pink-200 p-4 hover:bg-pink-300 transition"
                        >

                            <div class="flex items-center gap-2">

                                <span class="text-sm p-1 rounded-full {{ $trace->status->colorClass() }}">
                                    <i class="{{ $trace->status->iconClass() }}"></i>
                                    {{ $trace->status->label() }}
                                </span>

                                <span class="font-semibold">
                                    {{ $trace->title }}
                                </span>

                            </div>

                            <div class="text-sm text-slate-500 mt-2">
                                {{ $trace->summary }}
                            </div>

                        </a>

                    @empty

                        Traceがまだありません🐶

                    @endforelse

                </div>

            </div>
        </div>

        <div class="relative h-full rounded-xl border border-neutral-200 dark:border-neutral-700">
            <div class="rounded-xl p-6">
                @foreach($activityCounts as $date => $count)
                    <div class="flex">
                        <div class="w-24 font-mono">
                            {{ $date }}
                        </div>
                        <div>
                            {{ str_repeat('🧱', $count) }}
                        </div>
                    </div>
                @endforeach
            </div>
        </div>

    </div>
</x-layouts::app>
