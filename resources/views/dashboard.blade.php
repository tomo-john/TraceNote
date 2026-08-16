<x-layouts.base>
    <div class="min-h-screen flex flex-col items-center justify-center gap-8 bg-gradient-to-b from-slate-50 to-zinc-100 p-8">

        <div class="max-w-6xl w-full space-y-8">

            {{-- Hero --}}
            <x-ui.card class="w-full">

                <div class="flex items-center">

                    <div class="space-y-2">
                        <h2 class="text-lg font-bold text-slate-700">
                            今日も一歩ずつ、知識の木を育てよう。
                        </h2>
                        <p class="text-sm text-slate-500">
                            学んだことを記録して、少しずつ成長していきましょう。
                        </p>
                    </div>

                    <div class="flex-1 flex flex-col items-center justify-center gap-2">
                        <i class="fa-solid fa-dog {{ $growthInfo['dog']['colorClass'] }} {{ $growthInfo['dog']['sizeClass'] }}"></i>
                        <span class="text-sm font-semibold text-slate-500">
                            Lv. {{ $growthInfo['level'] }}
                        </span>
                    </div>

                </div>

            </x-ui.card>

            {{-- Count --}}
            <div class="grid grid-cols-3 gap-4 w-full">

                <x-ui.card class="flex flex-col gap-2">
                    <h2 class="text-lg font-bold text-slate-700 flex items-center gap-2">
                        <i class="fa-solid fa-book text-pink-400"></i>
                        学習記録
                    </h2>
                    <span class="text-md text-slate-500">{{ $traceCount }} Traces</span>
                </x-ui.card>

                <x-ui.card class="flex flex-col gap-2">
                    <h2 class="text-lg font-bold text-slate-700 flex items-center gap-2">
                        <i class="fa-solid fa-tag text-sky-400"></i>
                        集めた知識
                    </h2>
                    <span class="text-md text-slate-500">{{ $tagCount }} Tags</span>
                </x-ui.card>

                <x-ui.card class="flex flex-col gap-2">
                    <h2 class="text-lg font-bold text-slate-700 flex items-center gap-2">
                        <i class="fa-brands fa-pagelines text-green-400"></i>
                        成長レベル
                    </h2>
                    <span class="text-md text-slate-500">
                        Lv. {{ $growthInfo['level'] }}
                    </span>
                    <div class="w-full h-3 bg-slate-200 rounded-full overflow-hidden">
                        <div
                            class="h-full bg-green-400 rounded-full"
                            style="width: {{ $growthInfo['progress'] }}%"
                        >
                        </div>
                    </div>
                    <span class="text-sm text-slate-400">
                        あと {{ $growthInfo['remainingTraces'] }} Traces で次のレベル！
                    </span>
                </x-ui.card>
            </div>

            {{-- Activity History --}}
            <x-ui.card>
                <h2 class="text-lg font-bold text-slate-700 flex items-center gap-2">
                    <i class="fa-solid fa-chart-line text-amber-400"></i>
                    活動履歴
                </h2>

                <div class="flex gap-4 mt-2">

                    {{-- 曜日 --}}
                    <div class="grid grid-rows-7 gap-0.5 text-xs text-slate-500">
                        <div>Sun</div>
                        <div>Mon</div>
                        <div>Tue</div>
                        <div>Wed</div>
                        <div>Thu</div>
                        <div>Fri</div>
                        <div>Sat</div>
                    </div>

                    {{-- 草 --}}
                    <div class="inline-grid grid-flow-col grid-rows-7 gap-0.5">
                        @foreach($activityCounts as $activity)
                            <div class="size-3 rounded-sm {{ $activity['colorClass'] }}"
                                 title="{{ $activity['date'] }} : {{ $activity['count'] }}"
                            ></div>
                        @endforeach
                    </div>

                    <div class="flex-1 flex flex-col items-center justify-center gap-2">
                        <i class="fa-solid fa-dog {{ $growthInfo['dog']['colorClass'] }} {{ $growthInfo['dog']['sizeClass'] }}"></i>
                        <span class="text-sm font-semibold text-slate-500">
                            Lv. {{ $growthInfo['level'] }}
                        </span>
                    </div>

                </div>

                <div class="flex items-center gap-2 mt-4 text-xs text-slate-400">
                    <span>少ない</span>

                    <span class="size-3 rounded-sm bg-slate-400"></span>
                    <span class="size-3 rounded-sm bg-green-200"></span>
                    <span class="size-3 rounded-sm bg-green-300"></span>
                    <span class="size-3 rounded-sm bg-green-400"></span>
                    <span class="size-3 rounded-sm bg-green-500"></span>
                    <span class="size-3 rounded-sm bg-green-700"></span>

                    <span>多い</span>
                </div>
            </x-ui.card>

            <div class="grid grid-cols-2 gap-4 w-full">

                {{-- Status Badge --}}
                <x-ui.card>
                    <h2 class="text-lg font-bold text-slate-700 flex items-center gap-2">
                        <i class="fa-solid fa-chart-column text-amber-400"></i>
                        ステータス
                    </h2>

                    <div class="mt-6 space-y-3">
                        @foreach($statusCounts as $status)
                            <div class="flex items-center justify-between rounded-xl bg-slate-50 px-4 py-3">

                                <div class="flex items-center gap-2">
                                    <span class="{{ $status['colorClass'] }} rounded-full px-3 py-1 text-xs font-medium">
                                        <i class="{{ $status['iconClass'] }}"></i>
                                        {{ $status['label'] }}
                                    </span>
                                </div>

                                <span class="font-bold text-slate-700">
                                    {{ $status['count'] }}
                                </span>

                            </div>
                        @endforeach
                    </div>
                </x-ui.card>

                {{-- Recently Trace --}}
                <x-ui.card class="w-full">
                    <h2 class="text-lg font-bold text-slate-700 flex items-center gap-2">
                        <i class="fa-solid fa-book-open text-amber-400"></i>
                        最近の学び
                    </h2>

                    <div class="mt-4 divide-y divide-slate-100">

                        @forelse ($recentTraces as $trace)

                            <a
                                href="{{ route('trace.show', $trace) }}"
                                wire:navigate
                                class="block py-4 first:pt-0 last:pb-0 hover:bg-slate-50 transition"
                            >
                                <div class="flex items-start gap-3">

                                    <x-ui.status-badge :status="$trace->status" />

                                    <div class="min-w-0 flex-1">
                                        <p class="font-semibold text-slate-700 truncate">
                                            {{ $trace->title }}
                                        </p>

                                        <p class="mt-1 text-sm text-slate-500 line-clamp-1">
                                            {{ $trace->summary }}
                                        </p>
                                    </div>

                                    <i class="fa-solid fa-chevron-right text-xs text-slate-300 mt-1"></i>

                                </div>
                            </a>

                        @empty

                            <div class="py-8 text-center text-slate-400">
                                <i class="fa-solid fa-dog text-2xl"></i>
                                <p class="mt-2 text-sm">
                                    まだTraceがありません
                                </p>
                            </div>

                        @endforelse

                    </div>

                </x-ui.card>

            </div>

        </div>

    </div>
</x-layouts.base>
