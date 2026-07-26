<div class="max-w-6xl mx-auto py-10 px-4 space-y-8">

    <div class="space-y-4">
        <h1 class="text-3xl font-bold text-slate-700">
            <i class="fa-solid fa-gear"></i>
            設定
        </h1>

        <p class="text-md text-slate-500">
            プロフィールやアカウントを管理します。
        </p>

        <hr class="border-dashed border-slate-200">
    </div>

    <div class="grid grid-cols-2 gap-6">

        {{-- 基本情報 --}}
        <x-ui.card>

            <div class="border-b border-slate-200 pb-4">
                <h2 class="text-lg font-bold text-slate-700 flex items-center gap-2">
                    <i class="fa-solid fa-user"></i>
                    プロフィール
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    名前とメールアドレスを変更します。
                </p>
            </div>

            <form wire:submit="saveProfile" class="space-y-6 mt-4">

                <div class="space-y-2">
                    <label for="name" class="text-sm font-semibold text-slate-700">名前</label>

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
                    <label for="email" class="text-sm font-semibold text-slate-700">メールアドレス</label>

                    <x-ui.input
                        wire:model="email"
                        id="email"
                        name="email"
                        type="email"
                        required
                    />

                    <x-ui.error name="email" />
                </div>

                <div class="flex justify-end">
                    <x-ui.button type="submit">
                        <i class="fa-solid fa-floppy-disk text-sm"></i>
                        更新
                    </x-ui.button>
                </div>

            </form>

        </x-ui.card>

        {{-- パスワード変更 --}}
        <x-ui.card>

            <div class="border-b border-slate-200 pb-4">
                <h2 class="text-lg font-bold text-slate-700 flex items-center gap-2">
                    <i class="fa-solid fa-key"></i>
                    パスワード変更
                </h2>
                <p class="text-sm text-slate-500 mt-1">
                    現在のパスワードを変更します。
                </p>
            </div>

            <form wire:submit="savePassword" class="space-y-6 mt-4">

                <div class="space-y-2">
                    <label for="current_password" class="text-sm font-semibold text-slate-700">現在のパスワード</label>

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
                    <label for="password" class="text-sm font-semibold text-slate-700">新しいパスワード</label>

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
                    <label for="password_confirmation" class="text-sm font-semibold text-slate-700">確認</label>

                    <x-ui.input
                        wire:model="password_confirmation"
                        id="password_confirmation"
                        name="password_confirmation"
                        type="password"
                        required
                    />

                    <x-ui.error name="password_confirmation" />
                </div>

                <div class="flex justify-end">
                    <x-ui.button type="submit">
                        <i class="fa-solid fa-key text-sm"></i>
                        更新
                    </x-ui.button>
                </div>

            </form>

        </x-ui.card>

    </div>

    {{-- アカウント削除 --}}
    <x-ui.card class="border-rose-200">

        <div class="border-b border-rose-200 pb-4">
            <h2 class="font-bold text-rose-700">
                <i class="fa-solid fa-bomb"></i>
                Danger Zone
            </h2>
            <p class="text-sm text-rose-500 mt-1">
                この操作は取り消せません。                
            </p>
        </div>

        <p class="mt-4 text-sm text-slate-500">
            アカウントを削除すると、<br>
            すべてのデータが削除されます。
        </p>

        <div class="mt-6">
            <x-ui.button variant="danger" wire:click="openDeleteModal">
                アカウントを削除する
            </x-ui.button>
        </div>

    </x-ui.card>

    {{-- アカウント削除モーダル --}}
    @if($showDeleteModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-slate-900/40 backdrop-blur-sm"
             @keydown.escape.window="$wire.closeDeleteModal()"
             @click.self="$wire.closeDeleteModal()"
        >
            <x-ui.card class="max-w-md w-full">

                <form wire:submit="deleteAccount" class="space-y-6">

                    <h2 class="flex items-center gap-2 text-xl font-bold text-red-600">
                        <i class="fa-solid fa-triangle-exclamation"></i>
                        アカウントを削除しますか？
                    </h2>

                    <p class="text-sm text-slate-500">
                        この操作は取り消せません!<br>
                        <br>
                        Trace・Tag・プロフィールなど、<br>
                        すべてのデータが完全に削除されます。
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

                    <div class="flex justify-end gap-4 pt-2">
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
