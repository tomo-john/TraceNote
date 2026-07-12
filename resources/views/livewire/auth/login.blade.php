<x-layouts.base>

    <div class="min-h-screen flex flex-col items-center justify-center">

        <x-ui.card class="max-w-md w-full text-center space-y-6">

            <div class="space-y-3">

                <x-ui.logo />

                <h1 class="text-2xl font-bold">
                    ログイン
                </h1>

                <p class="text-slate-500">
                    ログイン画面説明
                </p>

                <!-- Session Status -->
                <x-auth-session-status class="text-center" :status="session('status')" />

                <form method="POST" action="{{ route('login.store') }}" class="flex flex-col gap-6">
                    @csrf

                    <label for="email">Email Address</label>
                    <input
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required
                        autocomplete="email"
                        placeholder="email@example.com"
                    />

                    <label for="password">Password</label>
                    <input
                        name="password"
                        type="password"
                        required
                        autocomplete="current-password"
                        placeholder="パスワード"
                        viewable
                    />

                    @if (Route::has('password.request'))
                        <a class="" href="{{ route('password.request') }}" wire:navigate>
                            パスワードリセット
                        </a>
                    @endif

                    <label for="remember">チェックボックス</label>
                    <input type="checkbox" name="remember" />

                    <x-ui.button type="submit">
                        ログイン
                    </x-ui.button>

                </form>

                <span>アカウントをお持ちでない場合</span>
                <a href="{{ route('register') }}">新規登録</a>

            </div>

        </x-ui.card>

    </div>
</x-layouts.base>
