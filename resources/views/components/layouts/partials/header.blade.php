<header class="sticky top-0 z-50 backdrop-blur bg-white/80 border-b border-slate-100 shadow-sm">
    <div class="max-w-6xl mx-auto flex items-center justify-between px-6 py-3">

        {{-- ロゴ --}}
        <a href="{{ route('home') }}" class="flex items-center gap-3 text-lg text-slate-600 font-semibold hover:opacity-80 transition">
            <img src="{{ asset('favicon.svg')}}" class="w-8 h-8">
            <div class="flex flex-col">
                <span class="tracking-tight">Trace Note</span>
                <span class="text-xs text-slate-400">Learning journal</span>
            </div>
        </a>

        {{-- ナビ --}}
        <nav class="flex items-center gap-6 text-sm font-medium">

            <a href="{{ route('home') }}" class="text-slate-600 hover:text-slate-500 transition">
                Home
            </a>

            <a href="#" class="text-slate-600 hover:text-slate-500 transition">
                Test
            </a>

            @auth
                <flux:dropdown>
                    <flux:button variant="primary" icon-trailing="chevron-down" class="text-slate-600 font-bold hover:bg-slate-50 active:bg-slate-100 transition-all">
                        Main
                    </flux:button>

                    <flux:menu>
                        <flux:menu.item href="{{ route('trace.index') }}" icon="star">Trace</flux:menu.item>
                        <flux:menu.item href="{{ route('dashboard') }}" icon="star">Dashboard</flux:menu.item>
                        <flux:menu.item href="{{ route('profile.edit') }}" icon="cog">Profile</flux:menu.item>
                        <flux:menu.separator />
                        <form method="POST" action="{{ route('logout') }}" class="w-full">
                            @csrf
                            <flux:menu.item
                                as="button"
                                type="submit"
                                icon="arrow-right-start-on-rectangle"
                                class="w-full cursor-pointer"
                                variant="danger"
                            >
                                Logout
                            </flux:menu.item>
                        </form>
                    </flux:menu>
                </flux:dropdown>
            @endauth

            @guest
                <a href="{{ route('login') }}"
                   class="px-5 py-2 rounded-xl bg-slate-500 text-white font-bold hover:bg-slate-600 transition shadow-sm hover:shadow-lg active:scale-95 transition-all">
                    Login
                </a>
            @endguest

        </nav>
    </div>
</header>
