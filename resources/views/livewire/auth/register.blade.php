<x-layouts.base>

    <div class="min-h-screen flex flex-col items-center justify-center">

        <x-ui.card class="max-w-md w-full">

            <div class="space-y-6">

                <x-ui.logo />

                <h1 class="text-2xl font-bold text-slate-500 text-center my-4">
                    新規登録
                </h1>

                <!-- Session Status -->
                <x-auth-session-status class="text-center" :status="session('status')" />

                <form method="POST" action="{{ route('register.store') }}" class="flex flex-col gap-6">
                    @csrf

                    <div class="space-y-2">
                        <label for="name" class="text-sm font-semibold text-slate-700">Name</label>

                        <x-ui.input
                            id="name"
                            name="name"
                            :value="old('name')"
                            type="text"
                            required
                            autofocus
                            autocomplete="name"
                            placeholder="じょん"
                        />

                        <x-ui.error name="name" />
                    </div>

                    <div class="space-y-2">
                        <label for="email" class="text-sm font-semibold text-slate-700">Email Address</label>

                        <x-ui.input
                            id="email"
                            name="email"
                            :value="old('email')"
                            type="email"
                            required
                            autocomplete="email"
                            placeholder="email@example.com"
                        />

                        <x-ui.error name="email" />
                    </div>

                    <div class="space-y-2">
                        <label for="password" class="text-sm font-semibold text-slate-700">Password</label>

                        <x-ui.input
                            id="password"
                            name="password"
                            type="password"
                            required
                            autocomplete="new-password"
                            placeholder="パスワード"
                        />

                        <x-ui.error name="password" />
                    </div>

                    <div class="space-y-2">
                        <label for="password_confirmation" class="text-sm font-semibold text-slate-700">Confirm Password</label>

                        <x-ui.input
                            id="password_confirmation"
                            name="password_confirmation"
                            type="password"
                            required
                            autocomplete="new-password"
                            placeholder="パスワード"
                        />

                        <x-ui.error name="password_confirmation" />
                    </div>

                    <x-ui.button type="submit">
                        <i class="fa-solid fa-user-plus text-sm"></i>
                        登録
                    </x-ui.button>

                </form>

                <div class="text-center text-sm text-slate-500">

                    既にアカウントをお持ちですか？
                    <i class="fa-solid fa-paw"></i>

                    <x-ui.link :href="route('login')" wire:navigate>
                        ログイン
                    </x-ui.link>

                </div>

            </div>

        </x-ui.card>

    </div>
</x-layouts.base>
