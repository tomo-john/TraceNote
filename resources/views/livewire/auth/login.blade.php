<x-layouts.base>

    <div class="min-h-screen flex flex-col items-center justify-center">

        <x-ui.card class="max-w-md w-full space-y-6">

            <div class="space-y-3">

                <x-ui.logo />

                <p class="text-slate-500 text-center my-4">
                    <i class="fa-solid fa-dog mr-1"></i>
                    ログイン画面を作成中
                </p>

                <!-- Session Status -->
                <x-auth-session-status class="text-center" :status="session('status')" />

                <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-4">
                    @csrf

                    <label for="email" class="text-sm font-semibold text-slate-700">Email Address</label>

                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        placeholder="email@example.com"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-slate-700 placeholder:text-slate-400
                               focus:border-lime-500 focus:ring-2 focus:ring-lime-200 outline-none transition"
                    />

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
                        パスワードを忘れた場合
                    </x-ui.link>

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

                <span>アカウントをお持ちでない場合</span>
                <x-ui.link :href="route('register')" wire:navigate>
                    新規登録
                </x-ui.link>

            </div>

        </x-ui.card>

    </div>
</x-layouts.base>
