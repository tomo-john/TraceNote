<nav class="flex items-center gap-6 text-sm font-medium"
     x-data="dropdown()"
>

    <x-ui.nav-link :href="route('dashboard')">Dashboard</x-ui.nav-link>

    <x-ui.nav-link :href="route('trace.index')">Trace</x-ui.nav-link>

    <x-ui.button variant="" @click="toggle()">
        <i class="fa-solid fa-caret-down"></i>
        {{ auth()->user()->name }}
    </x-ui.button>

    <div x-show="open">
        <div class="fixed top-30 right-100 bg-black/40 flex items-center justify-center z-50">
            Dropdown Menu 🐶
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

                init() {
                    this.open = false;
                },

                toggle() {
                    this.open = !this.open;
                },
            }
        }
    </script>
</nav>
