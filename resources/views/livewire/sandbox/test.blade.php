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

            <x-ui.button tyep=button wire:click="openModal">
                Opne Modal
            </x-ui.button>

            <x-ui.button tyep=button variant="secondary" wire:click="closeModal">
                Close Modal
            </x-ui.button>

        </div>

    </x-ui.card>

    @if($showModal)
        <x-ui.modal maxWidth="sm">
            <i class="fa-solid fa-dog"></i>
        </x-ui.modal>
    @endif

</div>
