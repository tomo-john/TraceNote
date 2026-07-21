<div class="min-h-screen flex flex-col items-center justify-center">

    <x-ui.card class="max-w-md w-full">

        <div class="space-y-6">

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
                    :value="old('name')"
                    required
                />

                <x-ui.error name="name" />
            </div>

            <x-ui.button wire:click="save">
                保存する
                <i class="fa-solid fa-dog"></i>
            </x-ui.button>

        </div>

    </x-ui.card>
</div>
