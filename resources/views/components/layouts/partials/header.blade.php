<header class="sticky top-0 z-50 backdrop-blur bg-white/80 border-b border-slate-100 shadow-sm">
    <div class="max-w-6xl mx-auto flex items-center justify-between px-6 py-3">

        {{-- Logo --}}
        <x-ui.logo :href="route('home')" />

        {{-- Navi --}}
        @auth
            <x-layouts.partials.header-auth />
        @else
            <x-layouts.partials.header-guest />
        @endauth

    </div>
</header>
