<footer class="border-t border-slate-200 bg-white pt-12 pb-8 text-center">

    <x-ui.logo />

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
