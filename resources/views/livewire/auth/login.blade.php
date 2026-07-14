<x-layouts.base>

    <div class="min-h-screen flex flex-col items-center justify-center">

        <x-ui.card class="max-w-md w-full">

            <div class="space-y-6">

                <x-ui.logo />

                <h1 class="text-lg font-bold text-slate-500 text-center my-4">
                    ログイン
                </h1>

                <!-- Session Status -->
                <x-auth-session-status class="text-center" :status="session('status')" />

                <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-6">
                    @csrf

                    <div class="space-y-2">
                        <label for="email" class="text-sm font-semibold text-slate-700">Email Address</label>

                        <x-ui.input
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
                            placeholder="email@example.com"
                        />
                    </div>

                    <div class="space-y-2">
                        <label for="password" class="text-sm font-semibold text-slate-700">Password</label>

                        <input
                            name="password"
                            type="password"
                            required
                            autocomplete="current-password"
                            placeholder="パスワード"
                            class="w-full rounded-xl border border-slate-300 px-4 py-3 text-slate-700 placeholder:text-slate-400
                                   focus:border-lime-500 focus:ring-2 focus:ring-lime-200 outline-none transition"
                        />

                        <x-ui.link :href="route('password.request')" wire:navigate>
                            パスワードを忘れた場合はこちら
                            <i class="fa-solid fa-paw"></i>
                        </x-ui.link>
                    </div>


                    <div class="flex items-center gap-2">
                        <input
                            id="remember"
                            type="checkbox"
                            name="remember"
                            class="size-4 rounded border-slate-300 accent-lime-500"
                        >

                        <label for="remember"
                               class="text-sm text-slate-600 cursor-pointer"
                        >
                            ログイン状態を保持する
                        </label>
                    </div>

                    <x-ui.button type="submit">
                        ログイン
                    </x-ui.button>

                </form>

                <div class="text-center text-sm text-slate-500">

                    アカウントをお持ちでないですか？

                    <x-ui.link :href="route('register')" wire:navigate>
                        新規登録
                    </x-ui.link>

                </div>

            </div>

        </x-ui.card>

    </div>
</x-layouts.base>
