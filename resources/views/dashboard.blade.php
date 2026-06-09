<x-layouts::app :title="__('Dashboard')">
    <div class="flex h-full w-full flex-1 flex-col gap-4 rounded-xl">
        <div class="grid auto-rows-min gap-4 md:grid-cols-3">
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 flex items-center justify-center gap-2">
                <a href="{{ route('trace.index') }}">
                    <i class="fa-solid fa-dog text-sky-400"></i>
                    <span>{{ $traceCount }} Traces</span>
                </a>
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 flex items-center justify-center gap-2">
                <a href="{{ route('tag.index') }}">
                    <i class="fa-solid fa-tag text-sky-400"></i>
                    <span>{{ $tagCount }} Tags</span>
                </a>
            </div>
            <div class="relative aspect-video overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700 flex items-center justify-center gap-2">
                <div class="flex flex-col items-start gap-2">
                    @foreach($statusCounts as $status)
                        <span class="">{{ $status['label'] }}: {{ $status['count'] }}</span>
                    @endforeach
                </div>
            </div>
        </div>
        <div class="relative h-full flex-1 overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
            <x-placeholder-pattern class="absolute inset-0 size-full stroke-gray-900/20 dark:stroke-neutral-100/20" />
        </div>
    </div>
</x-layouts::app>
