<div class="py-6 space-y-6">

    <x-ui.card class="max-w-xl mx-auto">
        <div class="flex items-center justify-center gap-2">
            <i class="fa-solid fa-dog"></i>
            <p>UI Test Livewire</p>
            <i class="fa-solid fa-dog"></i>
        </div>
    </x-ui.card>

    <x-ui.card class="max-w-xl mx-auto">

        <div class="flex items-center justify-center gap-6">

            <x-ui.button type='button' wire:click="openModal">
                Opne Modal
            </x-ui.button>

        </div>

    </x-ui.card>

    @if($showModal)
        <x-ui.modal size="md" close="closeModal" :blur="false" persistent>

            <div class="flex items-center justify-center gap-2 text-slate-600">
                <i class="fa-solid fa-dog"></i>
                Hello Dog
                <i class="fa-solid fa-dog"></i>
            </div>

        </x-ui.modal>
    @endif

</div>
