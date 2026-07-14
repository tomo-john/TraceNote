<x-layouts.base>
<div class="max-w-6xl mx-auto p-6">
    <div class="mb-6 flex justify-between items-center">
        <div>
            <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Sandbox Data Lab<i class="fa-solid fa-flask px-1"></i></h1>
            <p class="text-sm text-gray-500 mt-1">自己参照リレーション（trace_relations）の生データ検証</p>
        </div>
        <span class="px-3 py-1 bg-indigo-50 text-indigo-600 text-xs font-semibold rounded-full border border-indigo-100">
            Total: {{ $relations->count() }} rows
        </span>
    </div>

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-gray-50 border-b border-gray-100 text-xs font-semibold text-gray-600 uppercase tracking-wider">
                    <th class="p-4">ID</th>
                    <th class="p-4">From (繋ぎ元ID)</th>
                    <th class="p-4 text-center">Direction</th>
                    <th class="p-4">To (繋ぎ先ID)</th>
                    <th class="p-4">Relation Type</th>
                    <th class="p-4">Created At</th>
                </tr>
            </thead>

            <tbody class="divide-y divide-gray-50 text-sm text-gray-700">
                @forelse ($relations as $relation)
                    <tr class="hover:bg-slate-50/80 transition-colors duration-150">
                        <td class="py-4 px-6 font-mono font-medium text-gray-400">#{{ $relation->id }}</td>

                        <td class="py-4 px-6">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-slate-100 text-slate-800 font-mono text-xs font-semibold">
                                ID: {{ $relation->from_trace_id }}
                            </span>
                        </td>

                        <td class="py-4 px-6 text-center">
                            <span class="text-indigo-400 font-bold animate-pulse"><i class="fa-solid fa-arrow-right"></i></span>
                        </td>

                        <td class="py-4 px-6">
                            <span class="inline-flex items-center px-2.5 py-1 rounded-md bg-slate-100 text-slate-800 font-mono text-xs font-semibold">
                                ID: {{ $relation->to_trace_id }}
                            </span>
                        </td>

                        <td class="py-4 px-6">
                            @if($relation->relation_type->value === 'prerequisite')
                                <span class="px-2.5 py-1 bg-amber-50 text-amber-700 text-xs font-medium rounded-md border border-amber-200">
                                    <i class="fa-solid fa-dog pr-1"></i>前提知識
                                </span>
                            @elseif($relation->relation_type->value === 'child')
                                <span class="px-2.5 py-1 bg-blue-50 text-blue-700 text-xs font-medium rounded-md border border-blue-200">
                                    <i class="fa-solid fa-bowl-food pr-1"></i>子知識
                                </span>
                            @else
                                <span class="px-2.5 py-1 bg-gray-50 text-gray-600 text-xs font-medium rounded-md border border-gray-200">
                                    <i class="fa-solid fa-bone pr-1"></i>関連知識
                                </span>
                            @endif
                        </td>

                        <td class="py-4 px-6 text-gray-400 text-xs font-mono">
                            {{ $relation->created_at->format('Y-m-d H:i') }}
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center text-gray-400">
                            <div class="flex flex-col items-center justify-center space-y-2">
                                <span class="text-3xl">🐾</span>
                                <p class="text-sm font-medium">データが1件も登録されていません</p>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- Line --}}
<hr class="w-full my-6" />

{{-- UI Test --}}
<div class="max-w-6xl mx-auto p-6">

    <h1 class="text-2xl font-bold text-gray-800 tracking-tight">Sandbox UI Test</h1>

    <p class="text-sm text-gray-500 mt-1">Blade Components</p>

    <div class="max-w-md w-full mx-auto space-y-4">

        <div class="space-y-2">
            <label for="email" class="text-sm font-semibold text-slate-700">Email Address</label>

            <x-ui.input
                id="email"
                name="email"
                type="email"
                value="{{ old('email') }}"
                required
                autocomplete="email"
                placeholder="email@example.com"
            />
        </div>

        <div class="space-y-2">
            <label for="email" class="text-sm font-semibold text-slate-700">Email Address</label>

            <x-ui.input
                id="email"
                name="email"
                type="email"
                value="{{ old('email') }}"
                required
                autocomplete="email"
                placeholder="email@example.com"
            />
        </div>

    </div>
</div>

</x-layouts.base>
