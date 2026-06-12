<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">

        <div class="relative h-full rounded-xl border border-neutral-200 dark:border-neutral-700">
            <div class="rounded-xl p-6">

                <h2 class="font-bold text-lg mb-4">
                    Dashboard
                </h2>

                <div class="flex flex-col gap-4">
                    <div class="flex flex-wrap items-center gap-2">
                        <a href="{{ route('trace.index') }}">
                            <i class="fa-solid fa-dog text-sky-400 w-6"></i>
                            <span>{{ $traceCount }} Traces</span>
                        </a>
                        @foreach($statusCounts as $status)
                            <div class="w-12 text-center text-sm p-1 rounded-full {{ $status['colorClass'] }}">
                                <i class="{{ $status['iconClass'] }}"></i>
                                <span class="">{{ $status['count'] }}</span>
                            </div>
                        @endforeach
                    </div>

                    <div>
                        <a href="{{ route('tag.index') }}">
                            <i class="fa-solid fa-tag text-sky-400 w-6"></i>
                            <span>{{ $tagCount }} Tags</span>
                        </a>
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

                                <span class="text-sm text-slate-500">
                                    {{ $trace->summary }}
                                </span>

                            </div>

                        </a>

                    @empty

                        <p>
                            No Trace
                            <i class="fa-solid fa-dog"></i>
                        </p>

                    @endforelse

                </div>

            </div>
        </div>

        <div class="relative h-full rounded-xl border border-neutral-200 dark:border-neutral-700">
            <div class="rounded-xl p-6">

                <h2 class="font-bold text-lg mb-4">
                    活動履歴
                </h2>

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

        {{-- 検証用 --}}
        <div class="relative h-full rounded-xl border border-neutral-200 dark:border-neutral-700">
            <div class="rounded-xl p-6">

                <h2 class="font-bold text-lg mb-4">
                    検証
                    <i class="fa-solid fa-dog"></i>
                </h2>

                <div class="flex flex-col gap-2 text-sm text-slate-500">
                    @foreach($test as $key => $value)
                        <div>
                            {{ $key }} : {{ $value }}
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</x-layouts::app>
