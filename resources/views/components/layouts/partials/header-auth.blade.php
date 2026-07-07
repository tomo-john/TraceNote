<nav class="flex items-center gap-6 text-sm font-medium">

    <x-ui.nav-link :href="route('dashboard')">Dashboard</x-ui.nav-link>

    <x-ui.nav-link :href="route('trace.index')">Trace</x-ui.nav-link>

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

</nav>
