<x-layouts.base>

    <div class="min-h-screen flex flex-col items-center justify-center">

        <x-ui.card class="max-w-md w-full">

            <div class="space-y-6">

                <x-ui.logo />

                <h1 class="text-2xl font-bold text-slate-500 text-center my-4">
                    パスワードの再発行
                </h1>

                <p class="text-center text-sm text-slate-500">
                    登録済みメールアドレスを入力すると、</br>
                    パスワード再設定用のメールを送信します。
                </p>

                <!-- Session Status -->
                <x-auth-session-status class="text-center" :status="session('status')" />

                <form method="POST" action="{{ route('password.email') }}" class="flex flex-col gap-6">
                    @csrf

                    <div class="space-y-2">
                        <label for="email" class="text-sm font-semibold text-slate-700">Email</label>

                        <x-ui.input
                            id="email"
                            name="email"
                            :value="old('email')"
                            type="email"
                            required
                            autofocus
                            placeholder="email@example.com"
                        />

                        <x-ui.error name="email" />
                    </div>

                    <x-ui.button type="submit">
                        <i class="fa-solid fa-paper-plane text-sm"></i>
                        リセットメールを送信
                    </x-ui.button>

                </form>

                <div class="text-center text-sm text-slate-500">

                    もしくは
                    <i class="fa-solid fa-paw"></i>

                    <x-ui.link :href="route('login')" wire:navigate>
                        ログイン
                    </x-ui.link>

                </div>

            </div>

        </x-ui.card>

    </div>

</x-layouts.base>
