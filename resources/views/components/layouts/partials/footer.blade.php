<footer class="border-t border-slate-200 bg-white pt-12 pb-8 text-center">

    <div class="text-lg font-bold text-slate-600 flex items-center justify-center gap-2">
        <img src="{{ asset('favicon.svg')}}" alt="Trace Note logo" class="w-8 h-8 inline">
        Trace Note
    </div>

    <p class="text-sm text-slate-500 mt-3">
        学びの痕跡を積み重ねる学習ノート
    </p>

    <div class="flex justify-center gap-8 mt-6">
        <x-ui.nav-link :href="route('about')">About</x-ui.nav-link>
        <x-ui.nav-link :href="route('privacy')">Privacy</x-ui.nav-link>
        <x-ui.nav-link :href="route('contact')">Contact</x-ui.nav-link>
        <x-ui.nav-link :href="route('sandbox')" variant="special">Snadbox</x-ui.nav-link>
    </div>

    <div class="text-[10px] text-slate-300 mt-10 uppercase tracking-widest">
        © {{ date('Y') }} Trace Note - Powered by Laravel & Livewire 🐾
    </div>

</footer>
