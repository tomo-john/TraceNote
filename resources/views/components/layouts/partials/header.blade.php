<header class="sticky top-0 z-50 backdrop-blur bg-white/80 border-b border-slate-100 shadow-sm">
    <div class="max-w-6xl mx-auto flex items-center justify-between px-6 py-3">

        {{-- Logo --}}
        <a href="{{ route('home') }}" class="flex items-center gap-3 text-lg text-slate-600 font-semibold hover:opacity-80 transition">
            <img src="{{ asset('favicon.svg')}}" class="w-8 h-8">
            <div class="flex flex-col">
                <span class="tracking-tight">Trace Note</span>
                <span class="text-xs text-slate-400">Learning journal</span>
            </div>
        </a>

        {{-- Navi --}}
        @auth
            <x-layouts.partials.header-auth />
        @else
            <x-layouts.partials.header-guest />
        @endauth

    </div>
</header>
