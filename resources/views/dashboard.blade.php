<x-layouts.base>
    <div class="min-h-screen flex flex-col items-center justify-center gap-8 bg-gradient-to-b from-slate-50 to-zinc-100 p-8">

        <div class="max-w-6xl w-full space-y-8">

            {{-- Hero --}}
            <x-ui.card class="w-full">
                <p>今日も一歩ずつ、知識の木を育てよう。</p>
                <div class="flex items-center gap-4 mt-2">
                    <i class="fa-solid fa-dog text-2xl text-green-100"></i>
                    <i class="fa-solid fa-dog text-2xl text-green-200"></i>
                    <i class="fa-solid fa-dog text-2xl text-green-300"></i>
                    <i class="fa-solid fa-dog text-2xl text-green-500"></i>
                    <i class="fa-solid fa-dog text-2xl text-green-700"></i>
                </div>
            </x-ui.card>

            {{-- Count --}}
            <div class="grid grid-cols-3 gap-4 w-full">
                <x-ui.card class="flex flex-col gap-2">
                    <span>
                        <i class="fa-solid fa-book text-pink-400"></i>
                        学習記録
                    </span>
                    <span>{{ $traceCount }} Traces</span>
                </x-ui.card>

                <x-ui.card class="flex flex-col gap-2">
                    <span>
                        <i class="fa-solid fa-tag text-sky-400"></i>
                        集めた知識
                    </span>
                    <span>{{ $tagCount }} Tags</span>
                </x-ui.card>

                <x-ui.card class="flex flex-col gap-2">
                    <span>
                        <i class="fa-brands fa-pagelines text-green-400"></i>
                        成長レベル
                    </span>
                    <span>Lv.3</span>
                </x-ui.card>
            </div>

            {{-- Activity History --}}
            <div class="grid grid-cols-2 gap-4 w-full">
                <x-ui.card>
                    <span>
                        <i class="fa-solid fa-chart-line text-gray-400"></i>
                        活動履歴
                    </span>

                    <div class="flex gap-2 mt-2">
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

                        {{-- 犬 --}}
                        <div class="flex-1 flex items-center justify-center border border-slate-400 rounded-xl">
                            <i class="fa-solid fa-dog {{ $dog['colorClass'] }} {{ $dog['sizeClass'] }}"></i>
                        </div>
                    </div>

                </x-ui.card>

                <x-ui.card>
                    <span>
                        <i class="fa-solid fa-chart-column text-gray-400"></i>
                        ステータス
                    </span>

                    <div class="grid grid-cols-2 gap-4 mt-2">
                        @foreach($statusCounts as $status)
                            <div class="w-full text-center text-sm p-1 rounded-full {{ $status['colorClass'] }}">
                                <i class="{{ $status['iconClass'] }}"></i>
                                <span class="">{{ $status['label'] }}</span>
                                <span class="">{{ $status['count'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </x-ui.card>
            </div>

            {{-- Recently Trace --}}
            <x-ui.card class="w-full">
                <span>
                    <i class="fa-solid fa-book-open text-yellow-400"></i>
                    最近の学び
                </span>

                <div class="space-y-3 mt-2">

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
            </x-ui.card>

        </div>

    </div>
</x-layouts.base>
