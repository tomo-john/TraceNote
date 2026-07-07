<nav class="flex items-center gap-6 text-sm font-medium">

    <x-ui.nav-link :href="route('dashboard')">Dashboard</x-ui.nav-link>

    <x-ui.nav-link :href="route('trace.index')">Trace</x-ui.nav-link>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <x-ui.button type="submit" variant="danger">
            <i class="fa-solid fa-right-from-bracket"></i>
            Logout
        </x-ui.button>
    </form>

</nav>
