<nav class="flex items-center gap-6 text-sm font-medium">

    <x-ui.nav-link :href="route('dashboard')">Dashboard</x-ui.nav-link>

    <x-ui.nav-link :href="route('trace.index')">Trace</x-ui.nav-link>

    <div x-data="dropdown()" class="relative">
        <x-ui.button variant="" @click="toggle()">
            <i class="fa-solid fa-caret-down"></i>
            {{ auth()->user()->name }}
        </x-ui.button>

        <div x-show="open"
             @click.outside="close()"
             class="absolute z-50 mt-2 p-6 w-48 bg-white rounded-lg shadow-lg border"
        >
            <div class="flex flex-col gap-2">
                <x-ui.nav-link :href="route('profile.edit')" wire:navigate>Profile</x-ui.nav-link>
                <x-ui.nav-link>Logout</x-ui.nav-link>
            </div>
        </div>
    </div>

    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <x-ui.button type="submit" variant="danger">
            <i class="fa-solid fa-right-from-bracket"></i>
            Logout
        </x-ui.button>
    </form>

    <script>
        function dropdown() {
            return {
                open: false,

                toggle() {
                    this.open = !this.open;
                },

                close() {
                    this.open = false;
                },

            }
        }
    </script>
</nav>
