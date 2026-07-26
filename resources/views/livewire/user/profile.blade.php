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

                    <x-ui.error name="password_confirmation" />
                </div>

                <x-ui.button type="submit">
                    <i class="fa-solid fa-key text-sm"></i>
                    更新
                </x-ui.button>

            </form>

        </x-ui.card>

        {{-- アカウント削除 --}}
        <x-ui.card>

            <h1 class="text-2xl font-bold text-red-500 text-center my-4">
                アカウント削除
            </h1>

            <p class="text-sm text-slate-500">
                アカウントを削除すると、<br>
                すべてのデータが削除されます。
            </p>

            <x-ui.button variant="danger" wire:click="openDeleteModal">
                アカウントを削除する
            </x-ui.button>

        </x-ui.card>

        {{-- アカウント削除モーダル --}}
        @if($showDeleteModal)
            <div class="fixed inset-0 z-50 flex items-center justify-center bg-white/70">
                <x-ui.card>

                    <form wire:submit="deleteAccount" class="space-y-6">

                        <h2 class="text-xl font-bold text-red-500">
                            アカウントを本当に削除しますか？
                        </h2>

                        <p class="text-sm text-slate-500">
                            この操作は取り消せません!
                        </p>

                        <div class="space-y-2">
                            <label for="delete_password" class="text-sm font-semibold text-slate-700">現在のパスワード</label>

                            <x-ui.input
                                wire:model="delete_password"
                                id="delete_password"
                                name="delete_password"
                                type="password"
                                required
                            />

                            <x-ui.error name="delete_password" />
                        </div>

                        <div class="flex justify-end gap-2">
                            <x-ui.button variant="secondary" type="button" wire:click="closeDeleteModal">
                                キャンセル
                            </x-ui.button>

                            <x-ui.button variant="danger" type="submit">
                                削除する
                            </x-ui.button>
                        </div>

                    </form>

                </x-ui.card>
            </div>
        @endif

    </div>
</div>
