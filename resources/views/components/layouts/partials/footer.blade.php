<footer class="border-t border-slate-200 bg-white pt-12 pb-8 text-center">

    <div class="text-lg font-bold text-slate-600 flex items-center justify-center gap-2">
        <a href="{{ route('sandbox') }}">
            <img src="{{ asset('favicon.svg')}}" alt="Trace Note logo" class="w-8 h-8 inline">
        </a>
        Trace Note
    </div>

    <p class="text-sm text-slate-500 mt-3">
        学びの痕跡を積み重ねる学習ノート
    </p>

    <div class="flex justify-center gap-8 mt-6 text-sm">
        <a href="#" class="text-slate-400 hover:text-slate-500 transition-colors">About</a>
        <a href="#" class="text-slate-400 hover:text-slate-500 transition-colors">Privacy</a>
        <a href="#" class="text-slate-400 hover:text-slate-500 transition-colors">Contact</a>
    </div>

    <div class="text-[10px] text-slate-300 mt-10 uppercase tracking-widest">
        © {{ date('Y') }} Trace Note - Powered by Laravel & Livewire 🐾
    </div>

</footer>
