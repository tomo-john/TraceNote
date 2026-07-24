<div class="min-h-screen flex flex-col items-center justify-center">

    <div class="grid grid-cols-3 gap-6">

        {{-- 基本情報 --}}
        <x-ui.card class="max-w-md w-full">

            <form wire:submit="saveProfile" class="space-y-6">

                <h1 class="text-2xl font-bold text-slate-500 text-center my-4">
                    プロフィール
                </h1>


                <div class="space-y-2">
                    <label for="name" class="text-sm font-semibold text-slate-700">Name</label>

                    <x-ui.input
                        wire:model="name"
                        id="name"
                        name="name"
                        type="text"
                        required
                    />

                    <x-ui.error name="name" />
                </div>

                <div class="space-y-2">
                    <label for="email" class="text-sm font-semibold text-slate-700">Email</label>

                    <x-ui.input
                        wire:model="email"
                        id="email"
                        name="email"
                        type="email"
                        required
                    />

                    <x-ui.error name="email" />
                </div>

                <x-ui.button type="submit">
                    <i class="fa-solid fa-floppy-disk text-sm"></i>
                    更新
                </x-ui.button>

            </form>

        </x-ui.card>

        {{-- パスワード変更 --}}
        <x-ui.card class="max-w-md w-full">

            <form wire:submit="savePassword" class="space-y-6">

                <h1 class="text-2xl font-bold text-slate-500 text-center my-4">
                    パスワード変更
                </h1>


                <div class="space-y-2">
                    <label for="current_password" class="text-sm font-semibold text-slate-700">Current Password</label>

                    <x-ui.input
                        wire:model="current_password"
                        id="current_password"
                        name="current_password"
                        type="password"
                        required
                    />

                    <x-ui.error name="current_password" />
                </div>

                <div class="space-y-2">
                    <label for="password" class="text-sm font-semibold text-slate-700">New Password</label>

                    <x-ui.input
                        wire:model="password"
                        id="password"
                        name="password"
                        type="password"
                        required
                    />

                    <x-ui.error name="password" />
                </div>

                <div class="space-y-2">
                    <label for="password_confirmation" class="text-sm font-semibold text-slate-700">Confirm Password</label>

                    <x-ui.input
                        wire:model="password_confirmation"
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        required
                    />

                    <x-ui.error name="confirm_password" />
                </div>

                <x-ui.button type="submit">
                    <i class="fa-solid fa-key text-sm"></i>
                    更新
                </x-ui.button>

            </form>

        </x-ui.card>

        {{-- Coming Soon --}}
        <div class="max-w-6xl mx-auto flex flex-col items-center justify-center gap-8 p-8 animate-pulse">

            <x-ui.logo />

            <x-ui.card>
                <p>Coming Soon ...</p>
            </x-ui.card>

        </div>

    </div>
</div>
