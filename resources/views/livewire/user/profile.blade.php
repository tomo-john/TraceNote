<div class="min-h-screen flex flex-col items-center justify-center">

    <x-ui.card class="max-w-md w-full">

        <form wire:submit="save" class="space-y-6">

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
                登録
            </x-ui.button>

        </form>

    </x-ui.card>
</div>
