<nav class="flex items-center gap-6 text-sm font-medium">

    <x-ui.nav-link href="https://github.com/tomo-john/TraceNote"
                   target="_blank"
                   rel="noopener noreferrer"
    >
        GitHub
    </x-ui.nav-link>

    <x-ui.nav-link :href="route('login', ['email' => 'demo2@example.com'])">Demo</x-ui.nav-link>

    <x-ui.nav-link :href="route('login')" variant="special">Login</x-ui.button>

</nav>
