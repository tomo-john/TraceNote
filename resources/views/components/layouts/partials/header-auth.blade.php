<nav class="flex items-center gap-6 text-sm font-medium">

    <x-ui.nav-link :href="route('dashboard')">Dashboard</x-ui.nav-link>

    <x-ui.nav-link :href="route('trace.index')">Trace</x-ui.nav-link>

    <x-ui.nav-link :href="route('tag.index')">Tag</x-ui.nav-link>

    <div x-data="headerDropdown()" class="relative">
        <x-ui.button variant="ghost" @click="toggle()">
            <i class="fa-solid fa-caret-down"></i>
            {{ auth()->user()->name }}
        </x-ui.button>

        <div x-show="open"
             x-transition
             @click.outside="close()"
             class="absolute z-50 right-0 mt-2 p-6 w-48 bg-white rounded-lg shadow-lg border"
        >

            {{-- Dropdown Menu --}}
            <div class="flex flex-col gap-2">

                <x-ui.dropdown-item :href="route('user.show',)">
                    <i class="fa-solid fa-user w-4"></i>
                    Profile
                </x-ui.dropdown-item>

                <x-ui.dropdown-item :href="route('profile.edit')">
                    <i class="fa-solid fa-user w-4"></i>
                    Profile2
                </x-ui.dropdown-item>

                <hr class="border-gray-200 my-2">

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <x-ui.dropdown-item type="submit" danger>
                        <i class="fa-solid fa-right-from-bracket w-4"></i>
                        Logout
                    </x-ui.dropdown-item>
                </form>

            </div>

        </div>
    </div>

    <script>
        function headerDropdown() {
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
