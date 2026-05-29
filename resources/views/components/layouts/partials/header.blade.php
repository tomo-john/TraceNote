<header class="sticky top-0 z-50 backdrop-blur bg-white/80 border-b border-pink-100 shadow-sm">
    <div class="max-w-6xl mx-auto flex items-center justify-between px-6 py-3">

        {{-- ロゴ --}}
        <a href="{{ route('home') }}" class="flex items-center gap-2 text-lg text-pink-600 font-semibold hover:opacity-80 transition">
            <img src="{{ asset('favicon.svg')}}" class="w-8 h-8">
            <span class="tracking-tight">Trace Note</span>
        </a>

        {{-- ナビ --}}
        <nav class="flex items-center gap-6 text-sm font-medium">

            <a href="{{ route('home') }}" class="text-slate-600 hover:text-pink-500 transition">
                Home
            </a>

            <a href="#" class="text-slate-600 hover:text-pink-500 transition">
                Test
            </a>

            @auth
                <flux:dropdown>
                    <flux:button variant="primary" icon-trailing="chevron-down" class="text-pink-600 font-bold hover:bg-pink-50 active:bg-pink-100 transition-all">
                        Dog
                    </flux:button>

                    <flux:menu>
                        <flux:menu.item href="{{ route('trace.index') }}" icon="star">Main</flux:menu.item>
                        <flux:menu.item href="{{ route('dashboard') }}" icon="layout-grid">Dashboard</flux:menu.item>
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
                   class="px-5 py-2 rounded-full bg-pink-500 text-white font-bold hover:bg-pink-600 transition shadow-sm hover:shadow-lg active:scale-95 transition-all">
                    Login
                </a>
            @endguest

        </nav>
    </div>
</header>
