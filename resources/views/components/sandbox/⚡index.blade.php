<?php

use Livewire\Component;

new class extends Component
{
    public int $count = 0;
    public string $message = 'Hello Volt';

    public function increment(): void
    {
        $this->count++;
    }

};
?>

<div class="space-y-4">

    <div class="flex items-center gap-2 tex-slate-500">
        <i class="fa-solid fa-dog"></i>
        {{ $message }}
        <i class="fa-solid fa-dog"></i>
    </div>

    <div class="flex items-center justify-center gap-2">
        <i class="fa-solid fa-heart text-rose-500"></i>
        <span class="text-sm text-slate-500 font-bold">{{ $count }}</span>
    </div>

    <div class="flex items-center justify-center">
        <x-ui.button type="button"  variant="ghost" wire:click="increment">
            いいね
        </x-ui.button>
    </div>

</div>
